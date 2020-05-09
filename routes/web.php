<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/project', 'ProjectController');
Route::resource('/user', 'UserController');
Route::resource('/issue', 'IssueController');

/**
 * Ajax Filter routes
 */
Route::get('/ajax/project-assignee', 'AjaxFilterController@projectAssignee')->name('ajax.project.assignee');
Route::get('/ajax/issue', 'AjaxFilterController@issue')->name('ajax.issue.index');
