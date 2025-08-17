<?php

use App\Http\Controllers\Backend\AddonController;
use App\Http\Controllers\Backend\ExpenseController;
use App\Http\Controllers\Backend\PackageController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\ShiftController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');

    // Permissions Routes
    Route::group(['prefix' => 'permissions'], function () {
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
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index'])->middleware('permission:view user')->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->middleware('permission:create user')->name('users.create');
        Route::get('/{user}', [UserController::class, 'show'])->middleware('permission:view user')->name('users.show');
        Route::post('/', [UserController::class, 'store'])->middleware('permission:create user')->name('users.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->middleware('permission:update user')->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->middleware('permission:update user')->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->middleware('permission:delete user')->name('users.destroy');
        Route::get('/{userId}/delete', [UserController::class, 'destroy'])->middleware('permission:delete user');
    });

    // Route::group(['prefix' => 'expenses'], function () {
    //     Route::get('/', [ExpenseController::class, 'index'])->middleware('permission:view expense')->name('expenses.index');
    //     Route::get('/create', [ExpenseController::class, 'create'])->middleware('permission:create expense')->name('expenses.create');
    //     Route::post('/', [ExpenseController::class, 'store'])->middleware('permission:create expense')->name('expenses.store');
    //     Route::get('/{expense}/edit', [ExpenseController::class, 'edit'])->middleware('permission:update expense')->name('expenses.edit');
    //     Route::put('/{expense}', [ExpenseController::class, 'update'])->middleware('permission:update expense')->name('expenses.update');
    //     Route::delete('/{expense}', [ExpenseController::class, 'destroy'])->middleware('permission:delete expense')->name('expenses.destroy');
    // });

    Route::group(['prefix' => 'packages'], function () {
        Route::get('/', [PackageController::class, 'index'])->middleware('permission:view package')->name('packages.index');
        Route::get('/create', [PackageController::class, 'create'])->middleware('permission:create package')->name('packages.create');
        Route::post('/', [PackageController::class, 'store'])->middleware('permission:create package')->name('packages.store');
        Route::get('/{package}/edit', [PackageController::class, 'edit'])->middleware('permission:update package')->name('packages.edit');
        Route::put('/{package}', [PackageController::class, 'update'])->middleware('permission:update package')->name('packages.update');
        Route::delete('/{package}', [PackageController::class, 'destroy'])->middleware('permission:delete package')->name('packages.destroy');
    });

    // Route::group(['prefix' => 'payments'], function () {
    //     Route::get('/', [PaymentController::class, 'index'])->middleware('permission:view payment')->name('payments.index');
    //     Route::get('/create', [PaymentController::class, 'create'])->middleware('permission:create payment')->name('payments.create');
    //     Route::post('/', [PaymentController::class, 'store'])->middleware('permission:create payment')->name('payments.store');
    //     Route::get('/{payment}/edit', [PaymentController::class, 'edit'])->middleware('permission:update payment')->name('payments.edit');
    //     Route::put('/{payment}', [PaymentController::class, 'update'])->middleware('permission:update payment')->name('payments.update');
    //     Route::delete('/{payment}', [PaymentController::class, 'destroy'])->middleware('permission:delete payment')->name('payments.destroy');
    // });

    Route::group(['prefix' => 'shifts'], function () {
        Route::get('/', [ShiftController::class, 'index'])->middleware('permission:view shift')->name('shifts.index');
        Route::get('/create', [ShiftController::class, 'create'])->middleware('permission:create shift')->name('shifts.create');
        Route::post('/', [ShiftController::class, 'store'])->middleware('permission:create shift')->name('shifts.store');
        Route::get('/{shift}/edit', [ShiftController::class, 'edit'])->middleware('permission:update shift')->name('shifts.edit');
        Route::put('/{shift}', [ShiftController::class, 'update'])->middleware('permission:update shift')->name('shifts.update');
        Route::delete('/{shift}', [ShiftController::class, 'destroy'])->middleware('permission:delete shift')->name('shifts.destroy');
    });

    Route::group(['prefix' => 'addons'], function () {
        Route::get('/', [AddonController::class, 'index'])->middleware('permission:view addon')->name('addons.index');
        Route::get('/create', [AddonController::class, 'create'])->middleware('permission:create addon')->name('addons.create');
        Route::post('/', [AddonController::class, 'store'])->middleware('permission:create addon')->name('addons.store');
        Route::get('/{addon}/edit', [AddonController::class, 'edit'])->middleware('permission:update addon')->name('addons.edit');
        Route::put('/{addon}', [AddonController::class, 'update'])->middleware('permission:update addon')->name('addons.update');
        Route::delete('/{addon}', [AddonController::class, 'destroy'])->middleware('permission:delete addon')->name('addons.destroy');
    });

    // // Home/Dashboard
    Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('permission:view dashboard');
});
