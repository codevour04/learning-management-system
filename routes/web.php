<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TransactionController;

Route::middleware([Authenticate::class])->group(function () {
    // Route::get('profile', function () {
    //     return view('auth.profile');
    // })
    // ->name("profile");

    // Route::get('/', function () {
    //     if (Auth::check()) {
    //         return redirect()->route('dashboard');
    //     }

    //     return view('app.index');
    // });

    Route::group(['middleware' => ['permission:view roles and permissions']], function () {
        Route::get('roles-and-permissions', [PermissionController::class, 'index']);
    });

    Route::controller(UserController::class)->group(function () {
        Route::prefix('ajax')->group(function () {
            Route::get('users', [UserController::class, 'getUserList'])->middleware('can:view users');
            Route::post('user', 'store')->middleware('can:add users');
            Route::patch('user/{user}', 'update')->middleware('can:update users');
            Route::delete('user/{user}', 'destroy')->middleware('can:delete users');
            Route::put('user/{user}/permission', [UserController::class, 'givePermissionTo'])
            ->middleware('can:give permission users');
            Route::get('auth-user', [UserController::class, 'getAuthUser']);
            Route::get('auth-user-permissions', [UserController::class, 'getUserPermission']);
            Route::get('logout', 'logout');
            Route::get('permissions/user', [UserController::class, 'getAuthUserPermissions']);
        });
    });

    Route::controller(TransactionController::class)->group(function () {
        Route::prefix('ajax')->group(function () {
            Route::get('transactions', 'index');
        });
    });

    Route::get('ajax/permissions', [PermissionController::class, 'fetch']);


    Route::controller(CustomerController::class)->group(function () {
        Route::post('customer', [CustomerController::class, 'store']);
    });
});

Route::get('/{any}', [AppController::class, 'index'])->where('any', '.*');
