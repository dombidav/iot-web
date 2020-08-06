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

Route::get('/fan/{device}/{user}','FanController@show')->name("fan.show"); // Finds {Device}, authenticates {user}, gets the fan speed

Route::put('/fan/{device}/{user}','FanController@update')->name("fan.update"); // Finds {Device}, authenticates {user}, sets the thermometer value


Route::get('/heat/{device}/{user}','HeatingController@show')->name("heat.show"); // Finds {Device}, authenticates {user}, gets the heating status and thermometer data


Route::put('/heat/{device}/{user}','HeatingController@update')->name("heat.update"); // Finds {Device}, authenticates {user}, sets the heating status


Route::get('/camera/{device}/{user}','CameraController@show')->name("camera.show"); // Finds {Device}, authenticates {user}, gets the camera stream


Route::resource('worker','WorkerController');
Route::resource('workergroup','WorkerGroupController');

Route::resource('device', 'DeviceController')->except(['index']);
Route::get('/devices/{category?}', 'DeviceController@index')->name('device.index');

Route::resource('lock','LockController');
Route::resource('log', 'LogController');



















