<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "admin" middleware group. Make something great!
|
*/



Route::prefix("v1")->group(function () {

    Route::middleware("jwt")->group(function () {

        Route::controller(AdminAuthController::class)->prefix("admin-auth")->group(function () {
            Route::put('change-own-password', 'changeOwnPassword');
            Route::put('edit-own-profile', 'editOwnProfile');
            Route::post("logout", 'logout');
        });

        Route::controller(AdminController::class)->prefix("admin-panel")->group(function () {
            Route::get('profile', "adminProfile"); //this mean own profile of current logged in admin
            Route::get('user-lists', 'showUserLists');
            Route::get('user-profile/{id}', 'checkUserProfile');
        });

        Route::middleware('role:super-admin')->group(function () {
            Route::controller(AdminAuthController::class)->prefix("admin-auth")->group(function () {
                Route::post('create-admin', "createAdmin");
                Route::put('edit-admin-profile/{id}', 'editAdminProfile');
                Route::put('change-admin-password/{id}', 'changeAdminPassword');
            });

            Route::controller(AdminController::class)->prefix("admin-panel")->group(function () {
                Route::get('admin-lists', 'showAdminLists');
                Route::get('admin-profile/{id}', 'checkAdminProfile');
                Route::put('edit-user-profile/{id}', 'editUserProfile');
                Route::put('change-user-password/{id}', 'changeUserPassword');
            });
        });
    });


    Route::post('login', [AdminAuthController::class, 'login']);
});
