<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttractionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttractionCategoryController extends Controller
{
    public function index()
    {
        $categories = AttractionCategory::withCount('attractions')->paginate(10);
        return view('admin.attraction-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.attraction-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        AttractionCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.attraction-categories.index')
            ->with('success', 'Категория успешно создана');
    }

    public function edit(AttractionCategory $attractionCategory)
    {
        return view('admin.attraction-categories.edit', compact('attractionCategory'));
    }

    public function update(Request $request, AttractionCategory $attractionCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $attractionCategory->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.attraction-categories.index')
            ->with('success', 'Категория успешно обновлена');
    }

    public function destroy(AttractionCategory $attractionCategory)
    {
        $attractionCategory->delete();

        return redirect()->route('admin.attraction-categories.index')
            ->with('success', 'Категория успешно удалена');
    }
}
