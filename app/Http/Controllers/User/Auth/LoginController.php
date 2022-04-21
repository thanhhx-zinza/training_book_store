<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Profile;
use App\Models\User;
use App\Mail\WelcomeMail;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facade\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view("User.Auth.login");
    }

    public function login(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $request->session()->put('user', ['email' => $email]);
            if ($this->currentUser()->profile == null) {
                return redirect()->route('profile.create');
            } else {
                return redirect("/home");
            }
        } else {
            $request->session()->flash('error', 'Đăng nhập thất bại');
            return redirect('/login');
        }
    }
}
