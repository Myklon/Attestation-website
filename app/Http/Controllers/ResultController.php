<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Result;
use App\Models\Test;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Result $result)
    {
        $this->authorize('show', $result);
        return view('result.index', compact("result"));
    }
}
