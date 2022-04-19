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
        $id = request()->id;
        $quantity = $this->getProduct();
        if ($this->currentUser()->status == "normal") {
            if ($quantity < 10) {
                return view('User.Product.create', ['id' => $id]);
            } else {
                return redirect('/home')
                ->with('error', 'you had created a maximum of products. Please upgrade your account to premium to create more');
            }
        } else {
            if ($quantity < 100) {
                return view('User.Product.create', ['id' => $id]);
            } else {
                return redirect('/home')->with('error', 'you had created a maximum of products');
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $storeId = $request->id;
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
        $quantity = $this->getProduct();
        if ($this->currentUser()->status == "normal") {
            if ($quantity < 10) {
                if ($this->currentUser()->stores()->find($storeId)->products::create($product)) {
                    return redirect()->route('store.show', $storeId)->with('success', "create product successfully");
                } else {
                    return redirect()->route('store.show', $storeId)->with('error', 'can not create product');
                }
            } else {
                return redirect()->route('store.show', $storeId)
                ->with('error', 'you had created a maximum of products. Please upgrade your account to premium to create more');
            }
        } else {
            if ($quantity < 100) {
                if ($this->currentUser()->stores->find($storeId)->products()->create($product)) {
                    return redirect()->route('store.show', $storeId)->with('success', "create product successfully");
                } else {
                    return redirect()->route('store.show', $storeId)->with('error', 'can not create product');
                }
            } else {
                return redirect()->route('store.show', $storeId)->with('error', 'you had created a maximum of products');
            }
        }
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
        $product = $this->currentUser()->store->products()->find($id);
        if ($product) {
            return view('User.Product.edit', compact('product'));
        } else {
            return redirect('/store')->with('error', 'product not found');
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
        $product = $this->currentUser()->stores->products()->find($id);
        if ($product) {
            if ($product->update($productUpdate)) {
                $request->session()->flash('success', "update product successfully");
                return redirect('/store');
            } else {
                return redirect('/store')->with('error', 'can not update product');
            }
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
    public function destroy($id)
    {
        $product = $this->currentUser()->store->products()->find($id);
        if ($product) {
            if ($product->delete()) {
                return redirect('/store')->with('success', "delete product successfully");
            } else {
                return redirect('/store')->with('error', 'can not delete product');
            }
        } else {
            return redirect('/store')->with('error', 'product not found');
        }
    }

    public function getProduct()
    {
        $stores = $this->currentUser()->stores;
        $product = 0;
        foreach ($stores as $store) {
            $products = count($store->products);
            $product += $products;
        }
        return $product;
    }
}
