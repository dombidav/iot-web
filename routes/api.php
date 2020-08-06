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


Route::get('/thermo/{device_id}/{user_id}','ThermometerDataController@show')->name("thermo_show");

Route::get('/Fan/{device_id}/{user_id}','FandataController@show')->name("fan_show");

Route::put('/Fan/{device_id}/{user_id}','FandataController@update')->name("fan_update");


Route::get('/Heat/{device_id}/{user_id}','HeatingDataController@show')->name("heat_show");


Route::put('/Heat/{device_id}/{user_id}','HeatingdataController@update')->name("heat_update");


Route::get('/Camera/{device_id}/{user_id}','CameraController@show')->name("camera_show");


Route::resource('worker','WorkerController');
Route::resource('workergroup','WorkerGroupController');
Route::resource('lock','LockController');
Route::resource('log', 'LogController');



















