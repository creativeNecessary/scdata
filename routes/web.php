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


Route::post('api/getShipList', 'ShipController@getShipList');
Route::post('api/getShipDetail', 'ShipController@getShipDetail');
Route::get('api/stlmodel/{filename}', 'ShipController@getSTLFile');
Route::get('api/image/{filename}', 'ShipController@getImageFile');
