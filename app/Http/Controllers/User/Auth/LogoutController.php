<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout()
    {
        Auth::logout();
        session()->forget('user');
        return redirect('/login');
    }

    public function destroy()
    {
        $user = $this->currentUser();
        if ($user->delete()) {
            return redirect('/home')->with('success', 'delete user success');
        }
        return redirect('/home')->with('error', 'can not delete user');
    }
}
