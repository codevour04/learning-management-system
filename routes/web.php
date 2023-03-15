<?php

use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware([Authenticate::class])->group(function () {
    Route::get('/profile', function () {
        return view('auth.profile');
    })
    ->name("profile");

    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route("profile");
        }

        return view('welcome');
    });

    Route::group(['middleware' => ['permission:view roles and permissions']], function () {
        Route::get('/roles-and-permissions', [PermissionController::class, 'index']);
        Route::get('/permissions', [PermissionController::class, 'fetch']);
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/user', [UserController::class, 'index'])->middleware('can:view users');
        Route::post('/user', 'store')->middleware('can:add users');
        Route::patch('/user/{user}', 'update')->middleware('can:update users');
        Route::delete('/user/{user}', 'destroy')->middleware('can:delete users');
        Route::put('/user/{user}/permission', [UserController::class, 'givePermissionTo'])
        ->middleware('can:give permission users');
        Route::get('/logout', 'logout');
    });

    Route::get('/roles-and-permissions', function () {
        return view('home');
    })
    ->middleware('can:view roles and permissions');

    Route::get('/home', function () {
        return view('home');
    })
    ->name("home")
    ->middleware('can:view roles and permissions');

    Route::get('/user-management', function () {
        return view('home');
    })
    ->middleware('can:view users');

    Route::get('/courses', function () {
        return view('courses');
    })
    ->middleware('can:access course');
});
