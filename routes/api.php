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

Route::post('/access-control','WorkerAccessController@access')->name('acs.auth');
Route::get('/access-control/status', 'WorkerAccessController@getStatus')->name('acs.get_status');
Route::put('/access-control/status', 'WorkerAccessController@setStatus')->name('acs.set_status');
Route::get('/access-control/logging', 'WorkerAccessController@getLogging')->name('acs.get_logging');
Route::put('/access-control/logging', 'WorkerAccessController@setLogging')->name('acs.set_logging');

Route::post('authorize/worker','GroupController@addWorker');
Route::post('authorize/lock','GroupController@addLock');

Route::resource('worker','WorkerController');
Route::resource('group','GroupController');

Route::resource('device', 'DeviceController')->except(['index']);
Route::get('/devices/{category?}', 'DeviceController@index')->name('device.index');

Route::resource('lock','LockController');
Route::resource('log', 'LogController');



















