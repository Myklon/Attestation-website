<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
//        $products = Product::orderByDesc("id")->paginate(16);

//        return view('product.index', compact('products'));
        return view('test.index');
    }
}
