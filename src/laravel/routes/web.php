<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', function (){
    return view('pages.login');
})->name('login');

Route::middleware('auth')->group(function (){

    Route::get('/logout', function (){
        Auth::logout();
    })->name('logout');

    Route::get('/', function (){
        return view('pages.dashboard');
    })->name('home');
});

// Route to handle page reload in Vue except for api routes
//Route::get('/{any?}', function (){
//    return view('welcome');
//})->where('any', '^(?!api\/)[\/\w\.-]*');

//Route::get('/admin', function (){
//    return view('admin.index');
//});


