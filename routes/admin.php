<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AppSettingsController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;




    Auth::routes(['verify' => true]);


    Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {



    Route::get('dashboard', [AdminHomeController::class, 'index'])->name('dashboard');
    Route::get('/app-settings', [AppSettingsController::class, 'index'])->name('app-settings.index')->middleware(['can:admin-settings-edit']);
    Route::post('/update-app-settings', [AppSettingsController::class, 'update'])->name('app-settings.update')->middleware(['can:admin-settings-edit']);
    Route::any('/get-role-has-permissions/{role_id}', [PermissionController::class, 'getRoleHasPermissions'])->name('roles.permissions');
    Route::post('assign-permissions', [PermissionController::class, 'assignPermissions'])->name('permissions.assign');

    //Roles
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index')->middleware(['can:admin-role-view']);
    Route::any('get-roles', [RoleController::class, 'getRoles'])->name('roles.get')->middleware(['can:admin-role-view']);
    Route::get('edit-role', [RoleController::class, 'editRole'])->name('roles.edit')->middleware(['can:admin-role-edit']);
    Route::post('add-role', [RoleController::class, 'updateOrCreateRecord'])->name('roles.add')->middleware(['can:admin-role-create']);
    Route::any('/delete-role', [RoleController::class, 'deleteRole'])->name('roles.delete')->middleware(['can:admin-role-delete']);

    //users
    Route::any('/user', [UserController::class, 'index'])->name('user.index')->middleware(['can:admin-user-view']);
    Route::any('/user-list', [UserController::class, 'userList'])->name('user.list')->middleware(['can:admin-user-view']);
    Route::any('/save-update-user', [UserController::class, 'userCreateOrUpdate'])->name('user.store')->middleware(['can:admin-user-create']);
    Route::any('/edit-user/{id}', [UserController::class, 'edit'])->name('user.edit')->middleware(['can:admin-user-edit']);
    Route::any('/delete-user/{id}', [UserController::class, 'destroy'])->name('user.delete')->middleware(['can:admin-user-delete']);


        //Category
        Route::get('category', [CategoryController::class, 'index'])->name('category.index');
        Route::any('get-category', [CategoryController::class, 'getCategory'])->name('category.get');
        Route::get('edit-category', [CategoryController::class, 'editCategory'])->name('category.edit');
        Route::post('add-category', [CategoryController::class, 'updateOrCreateRecord'])->name('category.add');
        Route::any('/delete-category', [CategoryController::class, 'deleteCategory'])->name('category.delete');


        //Products
        Route::get('product', [ProductController::class, 'index'])->name('product.index');
        Route::any('products-list', [ProductController::class, 'productsList'])->name('product.get');
        Route::get('edit-product/{id}', [ProductController::class, 'editProduct'])->name('product.edit');
        Route::get('create-product', [ProductController::class, 'createProduct'])->name('product.create');
        Route::post('save-product', [ProductController::class, 'updateOrCreateRecord'])->name('product.store');
        Route::any('/delete-product', [ProductController::class, 'deleteProduct'])->name('product.delete');
    });



    Route::get('/admin-logout', [HomeController::class, 'customLogout'])->name('admin.logout');
    Route::get('/admin',[LoginController::class,'showAdminLoginForm'])->name('admin.login.view');
    Route::post('/admin',[LoginController::class,'adminLogin'])->name('admin.login');





