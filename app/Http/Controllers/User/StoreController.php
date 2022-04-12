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
    public function index()
    {
        $user = Auth::user();
        $store = $user->store;
        return view('User.Store.index', compact('store'));
    }

    public function add()
    {
        return view('User.Store.create_store');
    }

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
        $user = Auth::user();
        $user->store()->create($store);
        $request->session()->flash('success', "them cua hang thanh cong");
        return redirect('admin/store');
    }

    public function edit()
    {
        $user = Auth::user();
        $store = $user->store()->first();
        return view('User.Store.edit_store', compact('store'));
    }

    public function update(UpdateStoreRequest $request)
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
        $user = Auth::user();
        $user->store()->update($store);
        $request->session()->flash('success', "chinh sua cua hang thanh cong");
        return redirect('admin  /store');
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        $user->store->delete();
        $request->session()->flash('success', "xoa thanh cong");
        return redirect('/home');
    }

    public function showDetail($id)
    {
        $store = Store::find($id);
        $user = Auth::user();
        return view('frontend.store.store_detail', compact('store', 'user'));
    }
}
