<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('User.Product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        $this->currentUser()->store->products()->create($product);
        $request->session()->flash('success', "create product successfully");
        return redirect('/store');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $arr = [];
        foreach ($this->currentUser()->store->products as $product) {
            array_push($arr, $product->id);
        }
        if (in_array($id, $arr)) {
            $product = Product::find($id);
            if ($product) {
                return view('User.Product.edit', compact('product'));
            } else {
                return redirect('/store')->with('error', 'product not found');
            }
        } else {
            return redirect('/store')->with('error', 'you do not have permission to edit this product');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = $image->getClientOriginalName();
            $image->storeAs("uploads", $name, "public");
        }
        $productUpdate =
        [
            "name" => $request->name,
            "description" => $request->description,
            "images" => $name,
            'slug' => Str::slug($request->name),
            "price" => $request->price,
        ];
        $product = Product::find($id);
        if ($product) {
            $product->update($productUpdate);
            $request->session()->flash('success', "update product successfully");
            return redirect('/store');
        } else {
            return redirect('/store')->with('error', 'product not found');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if ($product) {
            $product->delete();
            $request->session()->flash('success', "delete product successfully");
            return redirect('/store');
        } else {
            return redirect('/store')->with('error', 'product not found');
        }
    }
}
