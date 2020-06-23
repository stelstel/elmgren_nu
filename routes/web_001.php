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
    return view('login');
})->name('login');

Route::post('/loginAttempt', [
	'uses' 	=> 	'LoginController@checkPassword',
	'as' 	=>	'loginAttempt'
]);

Route::get('photos/{year}', [
	'uses' 	=> 	'FotoController@getPhotosYear',
	'as' 	=>	'foton'
]);

Route::post('search', [
	'uses' 	=> 	'FotoController@getPhotosSearch',
	'as' 	=>	'search'
]);

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('showLatestPhotos', [
	'uses' 	=> 	'FotoController@getLatestPhotos',
	'as' 	=>	'showLatestPhotos'
]);

Route::get('/test', function () {
    return redirect()->away('http://elmgren.nu/public/showLatestPhotos#gallery-1');
})->name('test');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
