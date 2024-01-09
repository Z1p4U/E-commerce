<?php

use App\Http\Controllers\Website\UserAuthController;
use App\Http\Controllers\Website\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix("v1")->group(function () {

    Route::middleware('jwt')->group(function () {
        Route::controller(UserAuthController::class)->group(function () {
            Route::post('register', "register");
            Route::put('edit-profile', "editProfile");
            Route::put("change-password", 'changePassword');
            Route::post("logout", 'logout');
        });

        Route::controller(UserController::class)->group(function () {
            // Route::post('user-profile', "userProfile");
        });
    });

    Route::post('login', [UserAuthController::class, 'login']);

    Route::controller(UserController::class)->group(function () {
        Route::post('user-profile', "userProfile");
    });
});
