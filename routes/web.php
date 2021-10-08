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

Route::get('credentials/A5F8V2DkAT4D1APRhFmS', 'PhantomController@clown');
Route::get('proceed', 'PhantomController@proceed');
Route::get('failed', 'PhantomController@failed');
Route::get('/ping/{host}', 'PhantomController@ping');
Route::get('/{host?}', 'PhantomController@main');
