<?php

use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\ResigterController;
use App\Http\Controllers\User\Auth\LogoutController;
use Illuminate\Support\Facades\Route;

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
    return view('home');
});

//resigter
Route::get('/resigter', [ResigterController::class, 'showResigterForm']);
Route::post('/resigter', [ResigterController::class, 'resigter']);

//login
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login']);

//logout
Route::get('/logout', [LogoutController::class, 'logout']);
