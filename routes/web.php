<?php

use Illuminate\Support\Facades\Route;
use App\Users\Presentation\Controllers\AuthController;
use App\Users\Presentation\Controllers\UsersController;

/**
 * Клиентская часть
 */
Route::get('/', function () {
    return view('welcome');
})->name('index');

/**
 * Авторизация
 */
Route::group(['controller' => AuthController::class], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/register', function () {
            return view('auth.register');
        })->name('register.form');
        Route::post('/register', 'register')->name('register');

        Route::get('/login', function () {
            return view('auth.login');
        })->name('login.form');
        Route::post('/login', 'login')->name('login');

        Route::get('/forgot-password', function () {
            return view('auth.password_restore');
        })->name('password.restore.form');
        Route::post('/forgot-password', 'restorePassword')->name('password.restore');

        Route::get('/change-password/{user}', function () {
            return view('auth.password_change');
        })->name('password.change.form');
        Route::post('/change-password/{user}', 'changePassword')->middleware('signed')->name('password.change');
    });

    Route::get('/logout', 'logout')->middleware('auth')->name('logout');
});

/**
 * Панель администрирования
 */
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('/', function () {
        return view('admin.index');
    })->name('admin.index');

    Route::group(['prefix' => 'users', 'controller' => UsersController::class], function () {
        Route::get('/', 'index')->name('admin.users');
        Route::get('/create', 'create')->name('admin.users.create');
        Route::get('/download', 'download')->name('admin.users.download');
        Route::get('/edit/{id}', 'edit')->name('admin.users.edit');
        Route::post('/get_form/{id?}', 'getForm')->name('admin.users.get_form');
        Route::post('/store', 'store')->name('admin.users.store');
        Route::delete('/delete/{id}', 'delete')->name('admin.users.delete');
    });
});


