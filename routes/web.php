<?php

use App\Models\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\LogoutController;
use App\Http\Controllers\User\Auth\ResigterController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\StoreController;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

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
Route::post('/login', [LoginController::class, 'login']);

//logout
Route::delete('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware('MustBeAuthenticated')->group(function () {
//profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, "show"])->name('createProfile');
        Route::post('/', [ProfileController::class, "save"])->name("saveProfile");
    });
    //store
    Route::prefix('store')->middleware('MustBeAuthenticated')->group(function () {
        Route::get('/', [StoreController::class, "index"])->name('home_store');
        Route::get('/create', [StoreController::class, 'add'])->name('create_store');
        Route::post('/create', [StoreController::class, 'store'])->name('store_store');
        Route::get('/edit', [StoreController::class, 'edit'])->name('edit_store');
        Route::post('/edit', [StoreController::class, 'update'])->name('update_store');
        Route::delete('/delete', [StoreController::class, 'delete'])->name('delete_store');
    //product
        Route::prefix('/product')->group(function () {
            Route::get('/', [ProductController::class, 'add'])->name('create_product');
            Route::post('/', [ProductController::class, "store"])->name('store_product');
            Route::get('/edit/{slug}', [ProductController::class, "edit"])->name('edit_product');
            Route::post('/edit/{slug}', [ProductController::class, 'update'])->name('update_product');
            Route::delete('/delete/{slug}', [ProductController::class, 'delete'])->name('delete_product');
        });
    });
});
//client
Route::get("/", function (){
    $stores = Store::all();
    return view('frontend.store.store', compact('stores'));
});
Route::get('/stores/{id}', [StoreController::class, 'showDetail'])->name('store_detail');
