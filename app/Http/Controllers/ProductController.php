<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\FormTestCreateRequest;
use App\Http\Requests\Product\FormTestUpdateRequest;
use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use App\Services\ProductFileService;
use App\Services\ProductRecomendationsService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderByDesc("id")->paginate(16);

        return view('product.index', compact('products'));
    }

    public function createProductForm()
    {
        $categories = Category::limit(100)->get();
        return view('product.create', compact('categories'));
    }

    public function store(FormTestCreateRequest $request, ProductFileService $productFileService)
    {
        $data = $request->only('title','short_description','description','price','category_id');
        $data['user_id'] = Auth::id();
        if($request->file('cover')) $data['cover'] = ProductService::handleUploadedCover($request->cover);

        $product = Product::create($data);

        ProductService::handleUploadedFiles($request->file('files'), $product->id);

        return redirect()->route('product.show', $product->id)->with('success', __('product.create.success.success'));
    }

//    public function store(FormTestCreateRequest $request, ProductFileService $productFileService)
//    {
//        $data = $request->only('title','short_description','description','price','category_id');
//
//        $data['user_id'] = Auth::id();
//
//        if($request->hasFile('cover')) {
//            $cover = $request->cover->store('covers');
//            $data['cover'] = $cover;
//        }
//
//        $product = Product::create($data);
//
//        if($request->hasFile('files')) {
//            foreach($request->file('files') as $file)
//            {
//                $filename = $file->store('files');
//                File::create([
//                    'product_id' => $product->id,
//                    'path' => $filename,
//                ]);
//            }
//        }
//
//        return redirect()->route('product.show', $product->id)->with('success', __('product.create.success.success'));
//    }

    public function editProductForm(Product $product)
    {
        $this->authorize('edit', $product);
        $categories = Category::limit(100)->get();
        return view('product.edit', compact('categories', 'product'));
    }

    public function update(FormTestUpdateRequest $request, Product $product)
    {
        $this->authorize('edit', $product);
        $data = $request->only('title','short_description','description','price','category_id');

        if($request->hasFile('cover')) {
            if($product->cover === "covers/default.png")
            {
                $cover = $request->cover->store('covers');
                $data['cover'] = $cover;
            }
            else {
                $cover = $request->file('cover')->storeAs('', $product->cover);
            }
        }

        $product->update($data);

        if($request->hasFile('files')) {
            $files = File::where('product_id', $product->id)->get();
            if($files) {
                foreach($files as $file)
                {
                    Storage::delete($file->path);
                }
                File::where('product_id', $product->id)->delete();
            }
            foreach($request->file('files') as $file)
            {
                $filename = $file->store('files');
                File::create([
                    'product_id' => $product->id,
                    'path' => $filename,
                ]);
            }
        }
        return redirect()->route('product.show', $product->id)->with('success', __('product.edit.success.success'));
    }

    public function removeProduct(Product $product)
    {
        $this->authorize('delete', $product);
        if($product->cover !== "covers/default.png")
        {
            Storage::delete($product->cover);
        }

        $files = File::where('product_id', $product->id)->get();
        if($files) {
            foreach($files as $file)
            {
                Storage::delete($file->path);
            }
            File::where('product_id', $product->id)->delete();
        }
        $product->delete();

        return redirect()->route('product.index')->with('success', __('product.delete.success.success'));
    }

    public function showProduct(Product $product, ProductRecomendationsService $productRecomendationsService)
    {
        dd($product->files());
        $recommendations = $productRecomendationsService->getRecommendations($product->id, $product->category_id, 4);

        return view('product.show', compact('product', 'recommendations'));
    }
}
