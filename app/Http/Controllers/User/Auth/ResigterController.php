<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Requests\ResigterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ResigterController extends Controller
{
    public function show()
    {
        return view('User.Auth.register');
    }

    public function register(ResigterRequest $request)
    {
        $formValue =
        [
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ];
        $user = User::create($formValue);
        Auth::login($user);
        $request->session()->put('user', ['email' => $user -> email]);
        return redirect('/home');
    }
}
