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

  });

    Route::any('/get-all-categories', [CategoryController::class, 'getAllCategories']);


    Route::any('/login', [AuthController::class, 'login']);
    Route::any('/customer-signups', [AuthController::class, 'customerSignups']);
    Route::any('/register-biometric', [AuthController::class, 'registerBiometric']);
    Route::any('/login-biometric', [AuthController::class, 'loginBiometric']);



