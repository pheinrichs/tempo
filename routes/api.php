<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['web', 'auth']], function() {
    Route::resource('accounts', 'Json\AccountController');
    Route::get('accounts/{account}/tabs', 'Json\AccountTabController@index');
    Route::post('accounts/{account}/tabs', 'Json\AccountTabController@store');
    Route::get('accounts/{account}/tabs/{tab}', 'Json\AccountTabController@show');
    Route::patch('accounts/{account}/tabs/{tab}', 'Json\AccountTabController@update');
    Route::delete('accounts/{account}/tabs/{tab}', 'Json\AccountTabController@destroy');

    Route::get('accounts/{account}/contacts', 'Json\ContactController@index');
    Route::post('accounts/{account}/contacts', 'Json\ContactController@store');
    Route::get('accounts/{account}/contacts/{contact}', 'Json\ContactController@show');
    Route::patch('accounts/{account}/contacts/{contact}', 'Json\ContactController@update');
    Route::delete('accounts/{account}/contacts/{contact}', 'Json\ContactController@destroy');

    Route::post('accounts/{account}/tabs/{tab}/fields', 'Json\TabFieldController@store');
    Route::patch('accounts/{account}/tabs/{tab}/fields/{field}', 'Json\TabFieldController@update');
    Route::delete('accounts/{account}/tabs/{tab}/fields/{field}', 'Json\TabFieldController@destroy');
});