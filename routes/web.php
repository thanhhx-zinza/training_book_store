<?php

use App\Models\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\LogoutController;
use App\Http\Controllers\User\Auth\ResigterController;

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
Route::get('/register', [ResigterController::class, 'show']);
Route::post('/register', [ResigterController::class, 'register']);

//login
Route::get('/login', [LoginController::class, 'show']);
Route::post('/login', [LoginController::class, 'login']);

//logout
Route::delete('/logout', [LogoutController::class, 'logout'])->name('logout');

//profile
Route::prefix('profile')->middleware('MustBeAuthenticated')->group(function () {
    Route::get('/', [ProfileController::class, "show"])->name('createProfile');
    Route::post('/', [ProfileController::class, "save"])->name("saveProfile");
});
