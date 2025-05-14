<?php

use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;



// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['prefix' => 'backend', 'as' => 'backend.', 'middleware' => ['auth']], function () {

    // Permissions Routes
    Route::group(['prefix' => 'permissions'], function(){
        Route::get('/', [PermissionController::class, 'index'])->middleware('permission:view permission')->name('permissions.index');
        Route::get('/create', [PermissionController::class, 'create'])->middleware('permission:create permission')->name('permissions.create');
        Route::post('/', [PermissionController::class, 'store'])->middleware('permission:create permission')->name('permissions.store');
        Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->middleware('permission:update permission')->name('permissions.edit');
        Route::put('/{permission}', [PermissionController::class, 'update'])->middleware('permission:update permission')->name('permissions.update');
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->middleware('permission:delete permission')->name('permissions.destroy');
        Route::get('/{permissionId}/delete', [PermissionController::class, 'destroy'])->middleware('permission:delete permission');
    });

    // Roles Routes

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RoleController::class, 'index'])->middleware('permission:view role')->name('roles.index');
        Route::get('/create', [RoleController::class, 'create'])->middleware('permission:create role')->name('roles.create');
        Route::post('/', [RoleController::class, 'store'])->middleware('permission:create role')->name('roles.store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:update role')->name('roles.edit');
        Route::put('/{role}', [RoleController::class, 'update'])->middleware('permission:update role')->name('roles.update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->middleware('permission:delete role')->name('roles.destroy');
        Route::get('/{roleId}/delete', [RoleController::class, 'destroy'])->middleware('permission:delete role');
        Route::get('/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole'])->middleware('permission:update role');
        Route::put('/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole'])->middleware('permission:update role');
    });
        

    // Users Routes
    Route::group(['prefix' => 'users'], function(){ 
        Route::get('/', [UserController::class, 'index'])->middleware('permission:view user')->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->middleware('permission:create user')->name('users.create');
        Route::post('/', [UserController::class, 'store'])->middleware('permission:create user')->name('users.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->middleware('permission:update user')->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->middleware('permission:update user')->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->middleware('permission:delete user')->name('users.destroy');

        Route::get('/{userId}/delete', [UserController::class, 'destroy'])->middleware('permission:delete user');
    });
        
    // // Home/Dashboard
    Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('permission:view dashboard');
});
