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
Route::patch('/hosting/update/{id}', 'HostingController@update')->name('hosting.update')->middleware('verified');
Route::get('/hosting/edit/{id}', 'HostingController@edit')->name('hosting.edit')->middleware('verified');
Route::delete('/hosting/delete/{id}', 'HostingController@destroy')->name('hosting.delete')->middleware('verified');
Route::get('/hosting/hostview/{id}', 'HostingController@show')->name('hosting.show')->middleware('verified');//partyhost
Route::get('/hosting/userview/{id}','HostingController@userShow')->name('user.show')->middleware('verified');//user
Route::get('/hosting/close/{id}', 'HostingController@close')->name('hosting.close')->middleware('verified');

//Enters
Route::get('/enters', 'EnterController@index')->name('enter.index')->middleware('verified');
Route::post('/enters/store', 'EnterController@store')->name('enter.store')->middleware('verified');
Route::get('/enters/exit', 'EnterController@exitP')->name('enter.exitP')->middleware('verified');

//Spotify
Route::get('slogin','SpotifyAuthController@login')->name('slogin')->middleware('verified');
Route::get('callback', 'SpotifyAuthController@getAuthCode')->name('callback')->middleware('verified');
Route::get('slogout','SpotifyAuthController@logout')->name('slogout')->middleware('verified');

//Music
Route::post('hosting/{id}/musics', 'MusicController@addMusic')->name('music.add')->middleware('verified');

//Playlist
Route::post('hosting/{id}/playlist', 'PlaylistController@addMusicToPlaylist')->name('playlist.add')->middleware('verified');
Route::delete('hosting/{id}/playlist', 'PlaylistController@removeMusicFromPlaylist')->name('playlist.remove')->middleware('verified');

//Suggest
Route::post('hosting/{id}/suggest', 'MusicController@suggestMusic')->name('suggest.add')->middleware('verified');
Route::delete('hosting/{id}/suggest', 'MusicController@destroySuggest')->name('suggest.delete')->middleware('verified');

//Like
Route::post('hosting/{id}/like', 'MusicController@addLike')->name('playlist.addLike')->middleware('verified');
