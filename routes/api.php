<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;

    Route::group(['middleware' => ['auth:sanctum']], function(){
        //Logout
        Route::any('/api-logout', [AuthController::class, 'logout']);
        Route::post('/save-order', [OrderController::class, 'saveOrder']);

        Route::get('/get-all-categories', [CategoryController::class, 'getAllCategories']);
        Route::post('/save-category', [CategoryController::class, 'saveCategory']);
        Route::post('/update-profile', [AuthController::class, 'updateProfile']);
        Route::any('/delete-user', [AuthController::class, 'deleteProfile']);
        Route::post('/subs-cat', [AuthController::class, 'subsCat']);
        Route::post('/get-user-subscribed-categories', [AuthController::class, 'getUserSubscribedCategories']);

  });


Route::post('/save-company-info', [CategoryController::class, 'saveCompanyInfo']);
    Route::any('/login', [AuthController::class, 'login']);

    Route::any('/customer-signups', [AuthController::class, 'customerSignups']);
    Route::any('/register-biometric', [AuthController::class, 'registerBiometric']);
    Route::any('/login-biometric', [AuthController::class, 'loginBiometric']);



