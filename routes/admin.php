<?php

use App\Users\Presentation\Controllers\UsersController;

/**
 * Панель администрирования
 */
Route::group(['middleware' => ['auth', 'role:admin']], function () {
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
