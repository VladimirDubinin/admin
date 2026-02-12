<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controller\AuthController;

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

});
