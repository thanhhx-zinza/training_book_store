<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Mail\RemindCreateStoreMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;

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
//eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8wLjAuMC4wOjgwODBcL2FwaVwvYXV0aFwvbG9naW4iLCJpYXQiOjE2NTEwNDEyMDEsImV4cCI6MTY1MTA0NDgwMSwibmJmIjoxNjUxMDQxMjAxLCJqdGkiOiJ6VTNIUENOellYdFozQUJpIiwic3ViIjoxMDAwLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.QWEFNlIHj3O-e7Ba3IgGZ5R7gnoIbkkmVUuUHyKvm88
//eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8wLjAuMC4wOjgwODBcL2xvZ2luIiwiaWF0IjoxNjUxMDQxMjczLCJleHAiOjE2NTEwNDQ4NzMsIm5iZiI6MTY1MTA0MTI3MywianRpIjoiWmpPa3d3RmZ1TEd4N21QayIsInN1YiI6MTAxNiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.dwv3FHPZGLPe5YKXJrQgzCwNVVdCjlEtlIfx1hwETdc
