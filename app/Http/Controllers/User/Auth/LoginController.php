<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facade\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view("User.Auth.login");
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ]
        );
        $email = $request->input('email');
        $password = $request->input('password');
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $request->session()->put('user', ['email' => $email]);
            return redirect("/home");
        } else {
            $request->session()->flash('error', 'Đăng nhập thất bại');
            return redirect('/login');
        }
    }
}
