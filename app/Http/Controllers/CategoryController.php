<?php

namespace App\Http\Controllers;

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
}
