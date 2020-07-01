<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify'=> true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard')->middleware('verified');

//Creazione di un party
Route::get('/hosting', 'HostingController@index')->name('hosting.index')->middleware('verified');

Route::get('/hosting/create', 'HostingController@create')->name('hosting.create')->middleware('verified');

Route::post('/hosting/store', 'HostingController@store')->name('hosting.store')->middleware('verified');