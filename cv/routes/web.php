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
    return view('about');
})->name('about');

Route::get('kompetens', function () {
    return view('kompetens');
})->name('kompetens');

Route::get('samples', function () {
    return view('samples');
})->name('samples');

Route::get('yrkeserf', function () {
    return view('yrkeserf');
})->name('yrkeserf');

Route::get('utbildning', function () {
    return view('utbildning');
})->name('utbildning');

Route::get('languages', function () {
    return view('languages');
})->name('languages');

Route::get('pdfcv', [
	'as' => 'pdfcv', 
 	'uses' => 'PdfCvController@getpdf'
]);