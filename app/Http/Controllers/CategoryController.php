<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Test;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    public function productsByCategory(Category $category)
    {
        $tests = Test::where('category_id', $category->id)->orderByDesc('id')->paginate(16);
        return view('category.show', compact('category','tests'));
    }
}
