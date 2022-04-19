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
        if ($this->currentUser()->status == "normal") {
            if (count($stores) < 1) {
                return view('User.Store.create');
            } else {
                return redirect('/home')
                ->with('error', 'you had created a maximum of stores. Please upgrade your account to premium to create more');
            }
        } else {
            if (count($stores) < 3) {
                return view('User.Store.create');
            } else {
                return redirect('/home')->with('error', 'you had created a maximum of stores.');
            }
        }
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
        if ($this->currentUser()->status == "normal") {
            if (count($stores) < 1) {
                if ($this->currentUser()->stores()->create($store)) {
                    return redirect('/store')->with('success', "create store successfully");
                } else {
                    return redirect('/home')->with('error', 'can not create store');
                }
            } else {
                return redirect('/home')
                ->with('error', 'you had created a maximum of stores. Please upgrade your account to premium to create more');
            }
        } else {
            if (count($stores) < 3) {
                if ($this->currentUser()->stores()->create($store)) {
                    return redirect('/store')->with('success', "create store successfully");
                } else {
                    return redirect('/home')->with('error', 'can not create store');
                }
            } else {
                return redirect('/home')->with('error', 'you had created a maximum of stores.');
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
        $store = $this->currentUser()->stores->find($id);
        if ($store) {
            $user = $this->currentUser();
            return view('User.Store.show', compact('store', 'user'));
        } else {
            return redirect('/home')->with('error', 'Store not found');
        }
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
        } else {
            return redirect('/home')->with('error', 'Store not found');
        }
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
            } else {
                return redirect('/home')->with('error', 'can not update store');
            }
        } else {
            return redirect('/home')->with('error', 'Store not found');
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
        if ($this->currentUser()->stores->find($id)) {
            $store = $this->currentUser()->stores->find($id);
            if ($store) {
                if ($store->delete()) {
                    return redirect('/home')->with('success', "delete store successfully");
                } else {
                    return redirect('/store')->with('error', 'can not delete store');
                }
            } else {
                return redirect('/home')->with('error', 'Store not found');
            }
        } else {
            return redirect('/home')->with('error', 'you do not have permission to delete');
        }
    }
}
