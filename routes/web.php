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

Route::get('/test', function (App\Models\Video $video) {
	dd($video);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group( function () {

	Route::get('upload', 'VideoUploadController@index')->name('video.upload');

	Route::post('/videos', 'VideoController@store');
	Route::put('videos/{video}', 'VideoController@update');

	Route::get('/channel/{channel}/edit', 'ChannelSettingController@edit')->name('channel.edit');
	Route::put('/channel/{channel}/update', 'ChannelSettingController@update')->name('channel.update');

});
