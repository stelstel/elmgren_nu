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

Route::get('/home', [
	'uses' 	=> 	'HomeController@init',
	'as' 	=>	'home'
]);

Route::get('showLatestPhotos', [
	'uses' 	=> 	'FotoController@getLatestPhotos',
	'as' 	=>	'showLatestPhotos'
]);

//Route::post('/submit', 'HomeController@sendMail');

Route::post('/submit', [
	'uses' 	=> 	'HomeController@sendMail',
	'as' 	=>	'submit'
]);

Route::get('index','SearchDataController@index');

Route::get('search','SearchDataController@result');

Auth::routes();