<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'LoginController@showLoginForm')->name('admin.login');
Route::post('/', 'LoginController@login');
Route::post('/logout', 'LoginController@logout')->name('admin.logout');
Route::get('/home', 'HomeController@index');
Route::resource('/permission', 'PermissionController', ['as' => 'admin']);
Route::get('/role', 'RoleController@index')->name('admin.role.index');
Route::get('/role/{role}/assign', 'RoleController@assign')->name('admin.role.assign');
Route::post('/role/{role}/assign', 'RoleController@assignPermission')->name('admin.role.assignPermission');
Route::get('/role/{role}', 'RoleController@show')->name('admin.role.show');
Route::get('/role/{role}/revoke', 'RoleController@revoke')->name('admin.role.revoke');
Route::post('/role/{role}/revoke', 'RoleController@revokePermission')->name('admin.role.revokePermission');
Route::resource('/company', 'CompanyController', ['as' => 'admin']);
