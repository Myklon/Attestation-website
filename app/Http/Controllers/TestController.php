<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test\FormTestCreateRequest;
use App\Models\Category;
use App\Models\Test;
use App\Services\TestFileService;
use App\Services\TestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::where('is_active', 0)
            ->orderByDesc('id')
            ->paginate(16);

        return view('test.index', compact('tests'));
    }

    public function showTest(Test $test)
    {
        return view('test.show', compact('test'));
    }

    public function createTestForm()
    {
        $categories = Category::limit(100)->get();
        return view('test.create', compact('categories'));
    }

    public function store(FormTestCreateRequest $request, TestFileService $testFileService)
    {
//        $data = $request->only('title','short_description','description','price','category_id');
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        if($request->file('cover')) $data['cover'] = TestService::handleUploadedCover($request->cover);

        $test = Test::create($data);

//        ProductService::handleUploadedFiles($request->file('files'), $test->id);

        return redirect()->route('test.show', $test->id)->with('success', __('test.create.success.success'));
    }
}
