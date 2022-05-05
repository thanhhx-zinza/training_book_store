<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Jobs\updateTotalProductCount;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->NORMAL_LIMIT_PRODUCTS = 10;
        $this->PREMIUM_LIMIT_PRODUCTS = 100;
        $this->middleware(['MustBeAuthenticated', 'verified'])->except('index', 'show');
    }
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
        $totalProductCount = $this->currentUser()->totalProductCount();
        if ($this->currentUser()->status == "normal" && $totalProductCount >= $this->NORMAL_LIMIT_PRODUCTS) {
            return redirect('/store')
            ->with('error', 'you had created a maximum of products. Please upgrade your account to premium to create more');
        }
        if ($totalProductCount >= $this->PREMIUM_LIMIT_PRODUCTS) {
            return redirect('/store')->with('error', 'you had created a maximum of products');
        }
        return view('User.Product.create', ['id' => $id]);
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
        $totalProductCount = $this->currentUser()->totalProductCount();
        if ($this->currentUser()->status == "normal" && $totalProductCount >= $this->NORMAL_LIMIT_PRODUCTS) {
            return redirect()->route('store.show', $storeId)
            ->with('error', 'you had created a maximum of products. Please upgrade your account to premium to create more');
        }
        if ($totalProductCount >= $this->PREMIUM_LIMIT_PRODUCTS) {
            return redirect()->route('store.show', $storeId)->with('error', 'you had created a maximum of products');
        }
        if ($this->currentUser()->stores->find($storeId)->products()->create($product)) {
            $totalProduct = $this->currentUser()->total_product_count + 1;
            updateTotalProductCount::dispatch($totalProduct);
            return redirect()->route('store.show', $storeId)->with('success', "create product successfully");
        }
        return redirect()->route('store.show', $storeId)->with('error', 'can not create product');
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
        $storeId = request()->storeId;
        $product = $this->currentUser()->stores()->find($storeId)->products->find($id);
        if ($product) {
            return view('User.Product.edit', compact('product', 'storeId'));
        }
        return redirect('/store')->with('error', 'product not found');
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
        $storeId = request()->storeId;
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
        $product = $this->currentUser()->stores()->find($storeId)->products->find($id);
        if ($product) {
            if ($product->update($productUpdate)) {
                $request->session()->flash('success', "update product successfully");
                return redirect('/store');
            }
            return redirect('/store')->with('error', 'can not update product');
        }
        return redirect('/store')->with('error', 'product not found');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $storeId = request()->storeId;
        $product = $this->currentUser()->stores()->find($storeId)->products()->find($id);
        if ($product) {
            if ($product->delete()) {
                $totalProduct = $this->currentUser()->total_product_count - 1;
                updateTotalProductCount::dispatch($totalProduct);
                return redirect('/store')->with('success', "delete product successfully");
            }
            return redirect('/store')->with('error', 'can not delete product');
        }
        return redirect('/store')->with('error', 'product not found');
    }
}
