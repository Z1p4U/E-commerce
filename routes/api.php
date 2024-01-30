<?php

use App\Http\Controllers\Website\CheckoutController;
use App\Http\Controllers\Website\PasswordController;
use App\Http\Controllers\Website\UserAuthController;
use App\Http\Controllers\Website\UserController;
use App\Http\Controllers\Website\UserVoucherController;
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

    Route::middleware('auth:api')->group(function () {

        Route::middleware('jwt')->group(function () {

            Route::controller(UserAuthController::class)->prefix('user-auth')->group(function () {
                Route::put('edit-profile', "editProfile");
                Route::put("change-password", 'changePassword');
                Route::post("logout", 'logout');
            });

            Route::controller(UserController::class)->prefix('user')->group(function () {
                Route::get('profile', "profile");
                Route::get('user-profile/{id}', "userProfile");
            });

            Route::controller(UserVoucherController::class)->prefix('voucher')->group(function () {
                Route::get('list', "index");
                // Route::post('open', "open");
                Route::get('show/{id}', "show");
            });

            Route::controller(CheckoutController::class)->prefix('check-out')->group(function () {
                Route::post('purchase/{id}', "purchase");
                Route::post('add-to-cart', "addToCart");
                // Route::post('single-item-checkout/{id}', "singleItemCheckOut"); // for who don't want add to cart function. Just select Item Id and provide quantity
            });
        });
    });

    Route::post('login', [UserAuthController::class, 'login']);

    Route::controller(UserAuthController::class)->prefix('user-auth')->group(function () {
        Route::post('register', "register");
    });

    Route::controller(PasswordController::class)->prefix('password')->group(function () {
        Route::post('email', "sendResetLinkEmail");
        Route::post('reset', "resetPassword");
    });
});
