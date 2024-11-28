<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attraction;
use App\Models\AttractionCategory;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttractionController extends Controller
{
    public function index()
    {
        $attractions = Attraction::with(['categories', 'images'])->paginate(10);
        return view('admin.attractions.index', compact('attractions'));
    }

    public function create()
    {
        $categories = AttractionCategory::all();
        return view('admin.attractions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'nullable|string',
            'country' => 'nullable|string',
            'city' => 'nullable|string',
            'street' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'categories' => 'required|array',
            'categories.*' => 'exists:attraction_categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $attraction = Attraction::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'country' => $validated['country'],
            'city' => $validated['city'],
            'street' => $validated['street'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        if ($request->has('categories')) {
            $attraction->categories()->attach($request->categories);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('attractions', 'public');
                Image::create([
                    'path' => $path,
                    'attraction_id' => $attraction->id
                ]);
            }
        }

        return redirect()->route('admin.attractions.index')
            ->with('success', 'Достопримечательность успешно создана');
    }

    public function edit(Attraction $attraction)
    {
        $categories = AttractionCategory::all();
        $attraction->load(['categories', 'images']);
        return view('admin.attractions.edit', compact('attraction', 'categories'));
    }

    public function update(Request $request, Attraction $attraction)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'nullable|string',
            'country' => 'nullable|string',
            'city' => 'nullable|string',
            'street' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'categories' => 'required|array',
            'categories.*' => 'exists:attraction_categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $attraction->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'country' => $validated['country'],
            'city' => $validated['city'],
            'street' => $validated['street'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        if ($request->has('categories')) {
            $attraction->categories()->sync($request->categories);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('attractions', 'public');
                Image::create([
                    'path' => $path,
                    'attraction_id' => $attraction->id
                ]);
            }
        }

        return redirect()->route('admin.attractions.index')
            ->with('success', 'Достопримечательность успешно обновлена');
    }

    public function destroy(Attraction $attraction)
    {
        // Удаляем связанные изображения
        foreach ($attraction->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
        
        $attraction->delete();
        
        return redirect()->route('admin.attractions.index')
            ->with('success', 'Достопримечательность успешно удалена');
    }

    public function deleteImage(Image $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();
        
        return response()->json(['success' => true]);
    }
}