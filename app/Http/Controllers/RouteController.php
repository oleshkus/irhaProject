<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Attraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        $query = Route::with('images');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $routes = $query->paginate(9);

        return view('routes.index', compact('routes'));
    }

    public function show(Route $route)
    {
        $attractions = $route->getOrderedAttractions();
        return view('routes.show', compact('route', 'attractions'));
    }

    public function create()
    {
        $attractions = Attraction::all();
        return view('admin.routes.create', compact('attractions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'attractions' => 'required|string'
        ]);

        $route = Route::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        // Обработка достопримечательностей
        $attractions = json_decode($request->attractions);
        foreach ($attractions as $index => $attractionId) {
            $route->attractions()->attach($attractionId, ['order' => $index]);
        }

        return redirect()
            ->route('routes.show', $route)
            ->with('success', 'Маршрут успешно создан');
    }

    public function edit(Route $route)
    {
        $attractions = Attraction::all();
        $routeAttractions = $route->getOrderedAttractions();
        return view('admin.routes.edit', compact('route', 'attractions', 'routeAttractions'));
    }

    public function update(Request $request, Route $route)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'attractions' => 'required|array|min:2',
            'attractions.*' => 'exists:attractions,id'
        ]);

        $route->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Обновляем связи с достопримечательностями
        $route->attractions()->detach();
        foreach ($request->attractions as $index => $attractionId) {
            $route->attractions()->attach($attractionId, ['order' => $index]);
        }

        return redirect()->route('admin.routes.index')->with('success', 'Маршрут обновлен!');
    }

    public function destroy(Route $route)
    {
        $route->delete();
        return redirect()->route('admin.routes.index')->with('success', 'Маршрут удален!');
    }

    public function updateOrder(Request $request, Route $route)
    {
        $request->validate([
            'attractions' => 'required|array',
            'attractions.*' => 'exists:attractions,id'
        ]);

        // Обновляем порядок достопримечательностей
        $route->attractions()->detach();
        foreach ($request->attractions as $index => $attractionId) {
            $route->attractions()->attach($attractionId, ['order' => $index]);
        }

        return response()->json(['message' => 'Порядок обновлен']);
    }

    public function getDirectionsUrl(Route $route)
    {
        $attractions = $route->getOrderedAttractions();
        
        if ($attractions->isEmpty()) {
            return response()->json(['error' => 'Нет точек маршрута'], 400);
        }

        // Формируем URL для Google Maps
        $waypoints = $attractions->map(function ($attraction) {
            return $attraction->latitude . ',' . $attraction->longitude;
        })->implode('/');

        $url = "https://www.google.com/maps/dir/?api=1&destination=" . 
               $attractions->last()->latitude . "," . $attractions->last()->longitude .
               "&waypoints=" . $waypoints;

        return response()->json(['url' => $url]);
    }
}
