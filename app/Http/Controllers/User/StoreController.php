<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    public function __construct()
    {
        $this->NORMAL_LIMIT_STORES = 1;
        $this->PREMIUM_LIMIT_STORES = 3;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = $this->currentUser()->stores;
        return view('User.Store.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stores = $this->currentUser()->stores;
        if ($this->currentUser()->status == "normal" && count($stores) >= $this->NORMAL_LIMIT_STORES) {
            return redirect('/home')
            ->with('error', 'you had created a maximum of stores. Please upgrade your account to premium to create more');
        }
        if (count($stores) >= $this->PREMIUM_LIMIT_STORES) {
            return redirect('/home')->with('error', 'you had created a maximum of stores.');
        }
        return view('User.Store.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = $image->getClientOriginalName();
            $image->storeAs("uploads", $name, "public");
        }

        $store =
        [
            "name" => $request->name,
            "description" => $request->description,
            "images" => $name,
        ];
        $stores = $this->currentUser()->stores;
        if ($this->currentUser()->status == "normal" && count($stores) >= $this->NORMAL_LIMIT_STORES) {
            return redirect('/home')
            ->with('error', 'you had created a maximum of stores. Please upgrade your account to premium to create more');
        }
        if (count($stores) >= $this->PREMIUM_LIMIT_STORES) {
            return redirect('/home')
            ->with('error', 'you had created a maximum of stores');
        }
        if (!$this->currentUser()->stores()->create($store)) {
            return redirect('/home')->with('error', 'can not create store');
        }
        return redirect('/home')->with('success', 'create store successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $store = $this->currentUser()->stores->find($id);
        if ($store) {
            $user = $this->currentUser();
            return view('User.Store.show', compact('store', 'user'));
        }
        return redirect('/home')->with('error', 'Store not found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $store = $this->currentUser()->stores->find($id);
        if ($store) {
            return view('User.Store.edit', compact('store'));
        }
        return redirect('/home')->with('error', 'Store not found');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStoreRequest $request, $id)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = $image->getClientOriginalName();
            $image->storeAs("uploads", $name, "public");
        }

        $storeUpdate =
        [
            "name" => $request->name,
            "description" => $request->description,
            "images" => $name,
        ];
        if ($this->currentUser()->stores->find($id)) {
            $store = $this->currentUser()->stores->find($id);
            if ($store->update($storeUpdate)) {
                return redirect('/store')->with('success', "update store successfully");
            }
                return redirect('/home')->with('error', 'can not update store');
        }
            return redirect('/home')->with('error', 'Store not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->currentUser()->stores->find($id)) {
            $store = $this->currentUser()->stores->find($id);
            if ($store) {
                if ($store->delete()) {
                    return redirect('/home')->with('success', "delete store successfully");
                }
                    return redirect('/store')->with('error', 'can not delete store');
            }
                return redirect('/home')->with('error', 'Store not found');
        }
            return redirect('/home')->with('error', 'you do not have permission to delete');
    }
}
