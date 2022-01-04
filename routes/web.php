<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserCreditsController;

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

// Auth

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Users
Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');

Route::group(['middleware' => ['auth']], function () {
    Route::get('users/create', [UsersController::class, 'create'])
        ->name('users.create');
    Route::post('users', [UsersController::class, 'store'])
        ->name('users.store');
    Route::delete('users/{user}', [UsersController::class, 'destroy'])
        ->name('users.destroy');
    Route::get('users', [UsersController::class, 'index'])
        ->name('users');
    Route::get('users/{user}/edit', [UsersController::class, 'edit'])
        ->name('users.edit');
    Route::put('users/{user}', [UsersController::class, 'update'])
        ->name('users.update');
    Route::resource('products', ProductController::class);
    Route::get('credits', [UserCreditsController::class, 'index'])->name('credits.index');
    Route::post('credits', [UserCreditsController::class, 'store'])->name('credits.store');
    Route::get('credits/create', [UserCreditsController::class, 'create'])->name('credits.create');
    Route::get('credits/edit/{user}', [UserCreditsController::class, 'edit'])->name('credits.edit');

    Route::resource('suppliers', SupplierController::class);
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware('auth');

});
