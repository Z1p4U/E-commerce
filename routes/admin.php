<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\VoucherController;
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

    Route::middleware('auth:admin')->group(function () {
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

            Route::controller(CategoryController::class)->prefix("category")->group(function () {
                Route::get("list", "index");
                Route::get("show/{id}", "show");
                Route::post("store", 'store');
                Route::put("update/{id}", 'update');
                Route::delete("delete/{id}", 'destroy');
            });

            Route::controller(TagsController::class)->prefix("tags")->group(function () {
                Route::get("list", "index");
                Route::get("show/{id}", "show");
                Route::post("store", 'store');
                Route::put("update/{id}", 'update');
                Route::delete("delete/{id}", 'destroy');
            });

            Route::controller(ProductController::class)->prefix("product")->group(function () {
                Route::get("list", "index");
                Route::get("show/{id}", "show");
                Route::post("store", 'store');
                Route::put("update/{id}", 'update');
                Route::delete("delete/{id}", 'destroy');
            });

            Route::controller(ItemController::class)->prefix("item")->group(function () {
                Route::get("list", "index");
                Route::get("show/{id}", "show");
                Route::post("store", 'store');
                Route::put("update/{id}", 'update');
                Route::delete("delete/{id}", 'destroy');
            });

            Route::controller(StockController::class)->prefix("stock")->group(function () {
                Route::get("list", "index");
                Route::post("store", 'store');
            });

            Route::controller(ImportController::class)->prefix("import")->group(function () {
                Route::post("excel", 'ExcelImport');
                Route::post("csv", 'CsvImport');
            });

            Route::controller(ExportController::class)->prefix("export")->group(function () {
                Route::get("excel", 'ExcelExport');
                Route::get("csv", 'CsvExport');
            });

            Route::controller(PhotoController::class)->prefix("photo")->group(function () {
                Route::get("list", "index");
                Route::get("show/{id}", "show");
                Route::post("store", 'store');
                Route::delete("delete/{id}", 'destroy');
                Route::post('multiple-delete', 'deleteMultiplePhotos');
                Route::get("trash", 'trash');
                Route::patch("deleted-photo/{id}", "deletedPhoto");
                Route::patch("restore/{id}", "restore");
                Route::post("force-delete/{id}", "forceDelete");
                Route::post("clear-trash", "clearTrash");
            });

            Route::controller(VoucherController::class)->prefix("voucher")->group(function () {
                Route::get("list", "index");
                Route::post("today", "todayList");
                Route::post("store", 'store');
                Route::get("show/{id}", 'show');
                Route::delete("delete/{id}", 'destroy');
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
    });

    Route::post('login', [AdminAuthController::class, 'login']);
});
