<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RouteCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RouteCategoryController extends Controller
{
    public function index()
    {
        $categories = RouteCategory::paginate(10);
        return view('admin.route-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.route-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:route_categories',
            'description' => 'nullable|string'
        ]);

        RouteCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description']
        ]);

        return redirect()->route('admin.route-categories.index')
            ->with('success', 'Категория успешно создана');
    }

    public function edit(RouteCategory $category)
    {
        return view('admin.route-categories.edit', compact('category'));
    }

    public function update(Request $request, RouteCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:route_categories,name,' . $category->id,
            'description' => 'nullable|string'
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description']
        ]);

        return redirect()->route('admin.route-categories.index')
            ->with('success', 'Категория успешно обновлена');
    }

    public function destroy(RouteCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.route-categories.index')
            ->with('success', 'Категория успешно удалена');
    }
}
