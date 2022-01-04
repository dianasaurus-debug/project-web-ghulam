<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\AuthController as APIAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/products', [ProductController::class, 'index']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', [APIAuthController::class, 'profile']);
//    Route::put('/update/profile', [APIAuthController::class, 'update']);
    Route::post('/logout', [APIAuthController::class, 'logout']);
});
//API route for register new user
Route::post('/register', [APIAuthController::class, 'register']);
//API route for login user
Route::post('/login', [APIAuthController::class, 'login']);
