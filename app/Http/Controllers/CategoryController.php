<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $categories = Category::all();
        $announcements = $category->announcements()->orderByDesc('id')->paginate(9);

        return view('category.show', compact(['announcements', 'categories', 'category']));
    }

    public function put(Category $category, CreateCategory $request)
    {
        $category->update($request->validated());
        return redirect()->back()->with('success', 'Pomyślnie utworzyłeś kategorię.');
    }

    public function store(CreateCategory $request)
    {
        Category::create($request->validated());
        return redirect()->back()->with('success', 'Pomyślnie utworzyłeś kategorię.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Pomyślnie usunąłeś kategorie.');
    }

    public function adminIndex()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }
}
