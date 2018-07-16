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
Route::post('user/email-reset', 'Auth\AuthUserController@postUserEmailReset');
Route::post('user/password-reset', 'Auth\AuthUserController@postUserPasswordReset');
Route::get('token/reset/password/{token}', 'Auth\AuthUserController@getTokenPasswordReset');

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
        Route::post('acquired', 'WasteController@postAcquiredWaste');
        Route::post('demand/proposal', 'WasteController@postWasteProposal');
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
        Route::post('password/update', 'UserController@postPasswordUpdate');
    });

    Route::prefix('transfer')->group(function () {
        Route::post('accept', 'TransferController@postAcceptTransfer');
        Route::post('decline', 'TransferController@postDeclineTransfer');
        Route::post('cancel', 'TransferController@postCancelTransfer');
    });

    Route::middleware(['role.admin'])->group(function () {

        Route::prefix('admin')->group(function () {

            Route::get('dashboard', 'AdminController@dashboard')->name('admin.dashboard');

            Route::prefix('users')->group(function () {
                Route::get('list', 'AdminController@getUsersList');
                Route::get('create', 'AdminController@createUser');
                Route::post('create', 'AdminController@postUserCreate');
                Route::get('update/{id}', 'AdminController@updateUser');
                Route::post('update', 'AdminController@postUserUpdate');
                Route::post('list-data', 'AdminController@postUsersListData');
                Route::post('delete', 'AdminController@postUserDelete');

            });
        });
    });

});
Route::get('home', 'HomeController@index')->name('home');


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
