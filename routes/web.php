<?php

use App\Models\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\LogoutController;
use App\Http\Controllers\User\Auth\ResigterController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\StoreController;
use App\Http\Controllers\User\StripeController;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/home', function () {
    $user = Auth::user();
    $stores = Store::all();
    return view('home', compact('user', 'stores'));
})->middleware('MustBeAuthenticated')->name('home');

//resigter
Route::get('/register', [ResigterController::class, 'show']);
Route::post('/register', [ResigterController::class, 'register']);

//login
Route::get('/login', [LoginController::class, 'show']);
Route::post('/login', [LoginController::class, 'login'])->name('login');

//logout
Route::delete('/logout', [LogoutController::class, 'logout'])->name('logout');
//store and book
Route::resource('profile', ProfileController::class)->middleware('MustBeAuthenticated');
Route::resource('store', StoreController::class)->middleware('MustBeAuthenticated');
Route::resource('product', ProductController::class)->middleware('MustBeAuthenticated');
//Stripe
Route::get('/stripe', [StripeController::class, 'stripe']);
Route::post('/stripe', [StripeController::class, 'stripePost'])->name('stripe.post');
//verify email
Route::get('/email/verify', function () {
    return view('User.Auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function () {
    Auth::user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
