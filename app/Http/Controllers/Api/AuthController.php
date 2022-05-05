<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\LoginRequest;
use App\Models\Profile;
use Faker\Factory;

class AuthController extends ApiBaseController
{
    public function login(LoginRequest $request)
    {
        $token = $this->auth()->attempt(['email' => $request->email, 'password' => $request->password]);
        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        if ($this->currentUser()->profile == null) {
            Profile::create([
                'user_id' => $this->currentUser()->id,
                'name' => '',
                'first_name' => '',
                'last_name' => '',
                'phone_number' => '',
                'gender' => '',
                'dob' => '2001-11-02',
                'address' => '',
            ]);
        }
        return $this->createNewToken($token);
    }
}
