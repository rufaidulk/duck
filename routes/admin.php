<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'LoginController@showLoginForm')->name('admin.login');
Route::post('/', 'LoginController@login');
Route::post('/logout', 'LoginController@logout')->name('admin.logout');
Route::get('/home', 'HomeController@index')->middleware('adminAuthorization');
