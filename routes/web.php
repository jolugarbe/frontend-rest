<?php

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


Route::post('register-user', 'Auth\AuthUserController@postRegister');
Route::post('login-user', 'Auth\AuthUserController@postLogin');
Route::post('logout-user', 'Auth\AuthUserController@postLogout')->name('logout_user');
Route::get('home', 'HomeController@index');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
