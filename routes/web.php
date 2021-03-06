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
Route::any('/', array(
	'as' => 'cube-index',
	'uses' => 'cubeController@index',
));


Route::post('/', array(
	'as' => 'cube-store',
	'uses' => 'cubeController@store',
));

