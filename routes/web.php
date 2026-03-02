<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controller\AuthController;
use Modules\Users\Controllers\UsersController;

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/**
 * Панель администрирования
 */
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('/', function () {
        return view('admin.index');
    })->name('admin.index');

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UsersController::class, 'index'])->name('admin.users');
        Route::get('/create', [UsersController::class, 'create'])->name('admin.users.create');
        Route::get('/download', [UsersController::class, 'download'])->name('admin.users.download');
        Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('admin.users.edit');
        Route::post('/get_form/{id?}', [UsersController::class, 'getForm'])->name('admin.users.get_form');
        Route::post('/store', [UsersController::class, 'store'])->name('admin.users.store');
        Route::post('/delete/{id}', [UsersController::class, 'delete'])->name('admin.users.delete');
    });
});
