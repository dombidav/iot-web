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

Route::namespace('Api')->group(function (){
    Route::post('/access-control','ApiWorkerAccessController@access')->name('acs.auth');
    Route::get('/access-control/status', 'ApiWorkerAccessController@getStatus')->name('acs.get_status');
    Route::put('/access-control/status', 'ApiWorkerAccessController@setStatus')->name('acs.set_status');
    Route::get('/access-control/logging', 'ApiWorkerAccessController@getLogging')->name('acs.get_logging');
    Route::put('/access-control/logging', 'ApiWorkerAccessController@setLogging')->name('acs.set_logging');

    Route::post('authorize/worker','ApiGroupController@addWorker');
    Route::post('authorize/lock','ApiGroupController@addLock');
    Route::delete('authorize/worker','ApiGroupController@deleteWorker');
    Route::delete('authorize/lock','ApiGroupController@deleteLock');

    Route::resource('worker','ApiWorkerController');
    Route::resource('group','ApiGroupController');

    Route::put('/device/{device}/keep-alive', 'ApiDeviceController@keepAlive')->name('device.keep_alive');
    Route::resource('device', 'ApiDeviceController');

    Route::put('/lock/{lock}/keep-alive', 'ApiLockController@keepAlive')->name('lock.keep_alive');
    Route::resource('lock','ApiLockController');
    Route::resource('log', 'ApiLogController');
    Route::resource('user', 'ApiUserController');

    Route::prefix('auth')->group(function () {
        // Below mention routes are public, user can access those without any restriction.
        // Create New User
        Route::post('register', 'ApiAuthController@register');
        // Login User
        Route::post('login', 'ApiAuthController@login');

        // Refresh the JWT Token
        Route::get('refresh', 'ApiAuthController@refresh');

        // Below mention routes are available only for the authenticated users.
        Route::middleware('auth:api')->group(function () {
            // Get user info
            Route::get('user', 'ApiAuthController@user');
            // Logout user from application
            Route::post('logout', 'ApiAuthController@logout');
        });
    });

});

















