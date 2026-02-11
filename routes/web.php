<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controller\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth', [AuthController::class, 'authForm'])->name('auth.form');
Route::post('/auth', [AuthController::class, 'auth'])->name('auth');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Админка
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

});
