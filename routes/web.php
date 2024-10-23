<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;



    Auth::routes();


    Route::middleware(['auth','verified'])->group(function () {


        Route::get('/my-account', [CustomerController::class, 'myAc'])->name('web.my.account');

    });



    Route::get('/', [HomeController::class, 'index'])->name('user.index');




    Route::get('/logout', [HomeController::class, 'customLogout'])->name('user.logout');

    Route::group([],base_path("routes/admin.php"));


