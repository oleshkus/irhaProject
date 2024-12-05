<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Attraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::with('attractions')->paginate(10);
        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        $attractions = Attraction::all();
        return view('admin.routes.create', compact('attractions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'attractions' => 'required|array',
            'attractions.*' => 'exists:attractions,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $route = Route::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'user_id' => auth()->id()
        ]);

        // Получаем порядок достопримечательностей из JSON
        $attractionsOrder = $request->has('attractions_order') 
            ? json_decode($request->attractions_order, true) 
            : $validated['attractions'];

        // Прикрепляем достопримечательности с порядком
        $attractions = collect($attractionsOrder)->mapWithKeys(function ($id, $index) {
            return [$id => ['order' => $index]];
        })->all();

        $route->attractions()->attach($attractions);

        // Сохраняем изображения
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('routes', 'public');
                $images[] = ['path' => $path];
            }
            $route->images()->createMany($images);
        }

        // Возвращаем JSON-ответ для AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'redirect' => route('admin.routes.index'),
                'message' => 'Маршрут успешно создан.'
            ]);
        }

        return redirect()->route('admin.routes.index')
            ->with('success', 'Маршрут успешно создан.');
    }

    public function edit(Route $route)
    {
        $attractions = Attraction::all();
        return view('admin.routes.edit', compact('route', 'attractions'));
    }

    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'attractions' => 'required|array',
            'attractions.*' => 'exists:attractions,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $route->update([
            'name' => $validated['name'],
            'description' => $validated['description']
        ]);

        // Обновляем порядок достопримечательностей
        $attractionsOrder = $request->has('attractions_order') 
            ? json_decode($request->attractions_order, true) 
            : $validated['attractions'];

        $attractions = collect($attractionsOrder)->mapWithKeys(function ($id, $index) {
            return [$id => ['order' => $index]];
        })->all();

        $route->attractions()->sync($attractions);

        // Удаляем старые изображения
        foreach ($route->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        // Сохраняем новые изображения
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('routes', 'public');
                $images[] = ['path' => $path];
            }
            $route->images()->createMany($images);
        }

        // Возвращаем JSON-ответ для AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'redirect' => route('admin.routes.index'),
                'message' => 'Маршрут успешно обновлён.'
            ]);
        }

        return redirect()->route('admin.routes.index')
            ->with('success', 'Маршрут успешно обновлён.');
    }

    public function deleteImage($imageId)
    {
        $image = \App\Models\Image::findOrFail($imageId);
        
        // Проверяем, принадлежит ли изображение маршруту
        if ($image->imageable_type === Route::class) {
            // Удаляем файл
            Storage::disk('public')->delete($image->path);
            
            // Удаляем запись из базы данных
            $image->delete();
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 403);
    }

    public function destroy(Route $route)
    {
        // Удаляем изображения при удалении маршрута
        foreach ($route->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
        $route->attractions()->detach();
        $route->delete();

        return redirect()->route('admin.routes.index')
            ->with('success', 'Маршрут успешно удален.');
    }

    // public function show(Route $route)
    // {
    //     return view('admin.routes.show', compact('route'));
    // }
}
