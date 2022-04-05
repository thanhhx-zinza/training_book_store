<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function save(ProfileRequest $request, $id)
    {
        $formValue = [
            'name' => $request->name,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "dob" => $request->dob,
            'phone_number' => $request->phone_number,
            "gender" => $request->gender,
            "address" => $request->address,
            'user_id' => $id,
        ];
        Profile::create($formValue);
        return redirect("/home")->with('success', 'create profile successfully');
    }
}
