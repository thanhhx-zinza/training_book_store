<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function add()
    {
        return view('User.Product.create_product');
    }

    public function store(ProductRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = $image->getClientOriginalName();
            $image->storeAs("uploads", $name, "public");
        }

        $product =
        [
            "name" => $request->name,
            "description" => $request->description,
            "images" => $name,
            'slug' => Str::slug($request->name),
            "price" => $request->price,
        ];
        $user = Auth::user();
        $user->store->product()->create($product);
        $request->session()->flash('success', "them san pham thanh cong");
        return redirect('admin/store');
    }

    public function edit($slug)
    {
        $user = Auth::user();
        $product = $user->store->product->where('slug',$slug)->first();
        return view('User.Product.edit_product', compact('product'));
    }

    public function update(UpdateProductRequest $request,$slug)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = $image->getClientOriginalName();
            $image->storeAs("uploads", $name, "public");
        }

        $product =
        [
            "name" => $request->name,
            "description" => $request->description,
            "images" => $name,
            'slug' => Str::slug($request->name),
            "price" => $request->price,
        ];
        $user = Auth::user();
        $productUpdate = $user->store->product->where('slug', $slug)->first();
        $productUpdate->update($product);
        $request->session()->flash('success', "cap nhat san pham thanh cong");
        return redirect('/admin/store');
    }

    public function delete(Request $request,$slug)
    {
        $user = Auth::user();
        $delete = $user->store->product->where('slug', $slug)->first()->delete();
        $request->session()->flash('success', "xoa thanh cong");
        return redirect('admin/store');
    }
}
