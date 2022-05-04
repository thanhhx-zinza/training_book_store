<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends ApiBaseController
{
    public function index()
    {
        $profile = $this->currentUser()->profile;
        return response()->json($profile);
    }

    public function update(ProfileRequest $request)
    {
        $profileUpdate = [
            'name' => $request->name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'address' => $request->address,
        ];
        if ($this->currentUser()->profile->update($profileUpdate)) {
            return response()->json($profileUpdate, 200);
        };
    }
}
