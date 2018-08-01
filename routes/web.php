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
Route::post('api/getSTLFile', 'ShipController@getSTLFile');
Route::get('api/func/{filename}', 'ShipController@getFuncFile');
Route::post('api/checkUpdate', 'CheckUpdateController@checkUpdate');
Route::post('api/getUpdateApkFile', 'CheckUpdateController@getUpdateApkFile');
Route::post('api/getCommLinkList', 'CommLinkController@getCommLinkList');
Route::post('api/getCommLinkDetail', 'CommLinkController@getCommLinkDetail');
Route::post('api/getFilterData', 'ShipController@getFilterData');

Route::post('api/getAllShipName', 'ShipController@getAllShipName');

Route::post('api/checkUpdateTest', 'CheckUpdateController@checkUpdateTest');



