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

Route::post('/workerauth','AuthenticateWorkerController@auth')->name("workerauth");


Route::resource('worker','WorkerController');
Route::resource('workergroup','WorkerGroupController');

Route::resource('device', 'DeviceController')->except(['index']);
Route::get('/devices/{category?}', 'DeviceController@index')->name('device.index');

Route::resource('lock','LockController');
Route::resource('log', 'LogController');



















