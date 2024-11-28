<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Attraction;
use Illuminate\Http\Request;

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
            'attractions.*' => 'exists:attractions,id'
        ]);

        $route = Route::create([
            'name' => $validated['name'],
            'description' => $validated['description']
        ]);

        $route->attractions()->attach($validated['attractions']);

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
            'attractions.*' => 'exists:attractions,id'
        ]);

        $route->update([
            'name' => $validated['name'],
            'description' => $validated['description']
        ]);

        $route->attractions()->sync($validated['attractions']);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Маршрут успешно обновлен.');
    }

    public function destroy(Route $route)
    {
        $route->attractions()->detach();
        $route->delete();

        return redirect()->route('admin.routes.index')
            ->with('success', 'Маршрут успешно удален.');
    }
}
