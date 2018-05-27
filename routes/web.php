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

Route::middleware(['cookie'])->group(function () {

    Route::prefix('waste')->group(function () {

        Route::get('create', 'WasteController@getCreateWaste');
        Route::post('create', 'WasteController@postCreateWaste');
        Route::post('update', 'WasteController@postUpdateWaste');
        Route::get('update/{id}', 'WasteController@getUpdateWaste');
        Route::get('available', 'WasteController@getAvailableList');
        Route::post('available-data', 'WasteController@postAvailableData');

        Route::prefix('user')->group(function () {
            Route::get('offers', 'WasteController@getOffers');
            Route::post('offers-data', 'WasteController@postOffersData');
            Route::get('transfers', 'WasteController@getTransfers');
            Route::post('transfers-data', 'WasteController@postTransfersData');
            Route::get('requests', 'WasteController@getRequests');
            Route::post('requests-data', 'WasteController@postRequestsData');
        });

    });

});
Route::get('home', 'HomeController@index')->name('home');


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
