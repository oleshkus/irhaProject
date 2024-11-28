<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class AttractionController extends Controller
{
    public function index(Request $request)
    {
        $query = Attraction::with('images');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $attractions = $query->latest()->paginate(9);

        return view('attractions.index', compact('attractions'));
    }

    public function show(Attraction $attraction)
    {
        return view('attractions.show', compact('attraction'));
    }

    public function edit(Attraction $attraction)
    {
        return view('admin.attractions.edit', compact('attraction'));
    }

    public function update(Request $request, Attraction $attraction)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
        ]);

        $path = $attraction->image;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
        }

        $attraction->update([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'image' => $path,
        ]);

        return redirect()->route('admin.attractions.index')->with('success', 'Достопримечательность обновлена!');
    }

    public function store(Request $request)
    {
        $manager = new ImageManager(new Driver());

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|max:4096|mimes:jpeg,jpg,bmp,png',
        ]);

        try {
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images', 'public');
                    $imageFullPath = storage_path('app/public/' . $imagePath);

                    // Convert image to WebP format
                    $webpPath = preg_replace('/\.[^.]+$/', '.webp', $imageFullPath);
                    $image = $manager->read($imageFullPath);
                    $image->toWebp(80)->save($webpPath);

                    // Delete original image
                    \Storage::disk('public')->delete($imagePath);

                    // Save WebP image path
                    $imagePaths[] = str_replace(storage_path('app/public/'), '', $webpPath);
                }
            }

            Attraction::create([
                'name' => $request->name,
                'description' => $request->description,
                'location' => $request->location,
                'images' => json_encode($imagePaths),
            ]);

            return redirect()->route('admin.attractions.index')->with('success', 'Достопримечательность добавлена!');
        } catch (\Exception $e) {
            \Log::error('Image upload failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['images' => 'Image upload failed. Please try again.']);
        }
    }

    public function create()
    {
        return view('admin.attractions.create');
    }

    public function admin()
    {
        $attractions = Attraction::all();
        return view('admin.attractions.index', compact('attractions'));
    }

    public function destroy(Attraction $attraction)
    {
        if ($attraction->image) {
            \Storage::disk('public')->delete($attraction->image);
        }

        $attraction->delete();

        return redirect()->route('admin.attractions.index')->with('success', 'Достопримечательность удалена!');
    }

    public function destroyAll()
    {
        $attractions = Attraction::all();
        foreach ($attractions as $attraction) {
            if ($attraction->image) {
                \Storage::disk('public')->delete($attraction->image);
            }
            $attraction->delete();
        }

        return redirect()->route('admin.attractions.index')->with('success', 'Все достопримечательности удалены!');
    }
}
