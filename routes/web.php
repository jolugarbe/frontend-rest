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
        Route::post('delete', 'WasteController@postDeleteWaste');
        Route::get('update/{id}', 'WasteController@getUpdateWaste');
        Route::get('available', 'WasteController@getAvailableList');
        Route::get('demand', 'WasteController@getDemandList');
        Route::post('available-data', 'WasteController@postAvailableData');
        Route::post('demand-data', 'WasteController@postDemandData');
        Route::post('request', 'WasteController@postRequestWaste');
        Route::get('show/{id}', 'WasteController@getShowWaste');

        Route::prefix('user')->group(function () {
            Route::get('published', 'WasteController@getPublished');
            Route::post('offers-data', 'WasteController@postOffersData');
            Route::get('transfers', 'WasteController@getTransfers');
            Route::post('transfers-data', 'WasteController@postTransfersData');
            Route::get('requests', 'WasteController@getRequests');
            Route::post('requests-data', 'WasteController@postRequestsData');
            Route::get('show-transfer/{id}', 'WasteController@getShowTransfer');
            Route::get('show-transfer/pdf/{id}', 'WasteController@getShowTransferPdf');
            Route::get('show-request/{id}', 'WasteController@getShowRequest');
            Route::get('show-request/pdf/{id}', 'WasteController@getShowRequestPdf');
        });

    });

    Route::prefix('user')->group(function () {
        Route::get('show/{id}', 'UserController@getShowUser');
        Route::get('profile', 'UserController@getProfile');
        Route::post('update', 'UserController@postUpdate');
    });

});
Route::get('home', 'HomeController@index')->name('home');


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
