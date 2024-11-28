<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        $query = Route::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->has('difficulty') && $request->difficulty) {
            $query->where('difficulty', $request->difficulty);
        }

        $routes = $query->paginate(9); // 9 items per page

        return view('routes.index', compact('routes'));
    }

    public function show(Route $route)
    {
        return view('routes.show', compact('route'));
    }

    public function edit(Route $route)
    {
        return view('admin.routes.edit', compact('route'));
    }

    public function update(Request $request, Route $route)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'distance' => 'required|numeric',
        ]);

        $route->update([
            'name' => $request->name,
            'description' => $request->description,
            'distance' => $request->distance,
        ]);

        return redirect()->route('admin.routes.index')->with('success', 'Маршрут обновлен!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'distance' => 'required|numeric',
        ]);

        Route::create([
            'name' => $request->name,
            'description' => $request->description,
            'distance' => $request->distance,
        ]);

        return redirect()->route('admin.routes.index')->with('success', 'Маршрут добавлен!');
    }

    public function create()
    {
        return view('admin.routes.create');
    }

    public function admin()
    {
        $routes = Route::all();
        return view('admin.routes.index', compact('routes'));
    }

    public function destroy(Route $route)
    {
        $route->delete();

        return redirect()->route('admin.routes.index')->with('success', 'Маршрут удален!');
    }
}
