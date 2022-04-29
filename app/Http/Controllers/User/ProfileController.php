<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
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
        return view("User.Profile.createProfile");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfileRequest $request)
    {
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatar->storeAs('avatar', $avatar->getClientOriginalName(), 'avatar');
        }
        $formValue = [
            'name' => $request->name,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "dob" => $request->dob,
            'phone_number' => $request->phone_number,
            "gender" => $request->gender,
            "address" => $request->address,
            'avatar' => $avatar->getClientOriginalName(),
        ];
        $this->currentUser()->profile()->create($formValue);
        return redirect("/home")->with('success', 'create profile successfully');
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
    public function edit()
    {
        $profile = $this->currentUser()->profile;
        return view('User.Profile.edit', compact($profile));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request)
    {
        if ($request->avatar) {
            $avatar = $request->avatar;
            $avatar->storeAs('uploads', $avatar->getClientOriginalName(), 'public');
        }
        $formValue = [
            'name' => $request->name,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "dob" => $request->dob,
            'phone_number' => $request->phone_number,
            "gender" => $request->gender,
            "address" => $request->address,
            'avatar' => $avatar->getClientOriginalName(),
        ];
        if ($this->currentUser()->profile()->update($formValue)) {
            return response()->json([
                'status' => 200,
                'message' => "success",
            ]);
        }
        return response()->json(
            [
                'message' => "error",
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
