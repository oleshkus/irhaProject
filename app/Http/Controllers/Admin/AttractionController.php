<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attraction;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttractionController extends Controller
{
    public function index()
    {
        $attractions = Attraction::with(['images'])->paginate(10);
        return view('admin.attractions.index', compact('attractions'));
    }

    public function create()
    {
        return view('admin.attractions.create');
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
        $attraction->load( 'images');
        return view('admin.attractions.edit', compact('attraction'));
    }

    public function update(Request $request, Attraction $attraction)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $attraction->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude']
        ]);

        // Обработка новых изображений
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('attractions', 'public');
                $attraction->images()->create([
                    'path' => $path,
                    'name' => $attraction->name,
                    'alt' => $attraction->name
                ]);
            }
        }

        return redirect()->route('admin.attractions.index')->with('success', 'Достопримечательность успешно обновлена');
    }

    public function deleteImage($imageId)
    {
        $image = \App\Models\Image::findOrFail($imageId);
        
        // Проверяем, принадлежит ли изображение достопримечательности
        if ($image->imageable_type === Attraction::class) {
            // Удаляем файл
            Storage::disk('public')->delete($image->path);
            
            // Удаляем запись из базы данных
            $image->delete();
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 403);
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
}
