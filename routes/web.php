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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

//
//Route::get('/', 'SpaController@index')->name('main');
//
//Route::get('{path}', function () {
//    return view('welcome');
//})->where( 'path', '([A-z\d-\/_.]+)?' );
Route::get('/{any}', 'SpaController@index')->where('any', '.*');
