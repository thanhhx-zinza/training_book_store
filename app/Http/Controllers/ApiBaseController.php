<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ApiBaseController extends Controller
{
    public function auth()
    {
        return auth('api');
    }

    public function currentUser()
    {
        return $this->auth()->user();
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'status' => '200',
            'message' => 'thanh cong',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }
}
