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
        $store = $this->currentUser()->store;
        return view('User.Store.index', compact('store'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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

        if ($this->currentUser()->store()->create($store)) {
            return redirect('/store')->with('success', "create store successfully");
        } else {
            return redirect('/home')->with('error', 'can not create store');
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
        $store = $this->currentUser()->store::find($id);
        if ($store) {
            $user = $this->currentUser();
            return view('frontend.store.show', compact('store', 'user'));
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
        if ($this->currentUser()->store->id == $id) {
            $store = Store::find($id);
            if ($store) {
                return view('User.Store.edit', compact('store'));
            } else {
                return redirect('/home')->with('error', 'Store not found');
            }
        } else {
            return redirect('/store')->with('error', 'you do not have permission');
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
        if ($this->currentUser()->store->id == $id) {
            $store = $this->currentUser()->store::find($id);
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
        if ($this->currentUser()->store->id == $id) {
            $store = $this->currentUser()->store->find($id);
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
