<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controller\AuthController;
use Modules\Users\Controllers\UsersController;

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::get('/register', [AuthController::class, 'registerForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Админка
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UsersController::class, 'index'])->name('admin.users');
        Route::get('/create', [UsersController::class, 'create'])->name('admin.users.create');
        Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('admin.users.edit');
        Route::get('/get_form_params/{id?}', [UsersController::class, 'getForm'])->name('admin.users.get_form');
        Route::post('/store', [UsersController::class, 'store'])->name('admin.users.store');
    });
});
