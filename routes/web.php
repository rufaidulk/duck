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
    // $user = \App\User::find(2);
    // dd($user->assignRole('company'));
    // $role = \Spatie\Permission\Models\Role::where(['name' => 'admin'])->first();
    // dd($role);
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
