<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});

Route::post('/access-control','Api\ApiWorkerAccessController@access')->name('acs.auth');
Route::get('/access-control/status', 'Api\ApiWorkerAccessController@getStatus')->name('acs.get_status');
Route::put('/access-control/status', 'Api\ApiWorkerAccessController@setStatus')->name('acs.set_status');
Route::get('/access-control/logging', 'Api\ApiWorkerAccessController@getLogging')->name('acs.get_logging');
Route::put('/access-control/logging', 'Api\ApiWorkerAccessController@setLogging')->name('acs.set_logging');

Route::post('authorize/worker','Api\ApiGroupController@addWorker');
Route::post('authorize/lock','Api\ApiGroupController@addLock');
Route::delete('authorize/worker','Api\ApiGroupController@deleteWorker');
Route::delete('authorize/lock','Api\ApiGroupController@deleteLock');

Route::resource('worker','Api\ApiWorkerController');
Route::resource('group','Api\ApiGroupController');

Route::put('/device/{device}/keep-alive', 'Api\ApiDeviceController@keepAlive')->name('device.keep_alive');
Route::resource('device', 'Api\ApiDeviceController');



Route::put('/lock/{lock}/keep-alive', 'Api\ApiLockController@keepAlive')->name('lock.keep_alive');
Route::resource('lock','Api\ApiLockController');
Route::resource('log', 'Api\ApiLogController');



















