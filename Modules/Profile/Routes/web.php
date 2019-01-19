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

Route::prefix('profile')->group(function() {
    Route::get('/', 'ProfileController@index');
    Route::get('/setting', 'ProfileController@setting');
    Route::get('/details', 'ProfileController@editUser');
    Route::get('/edit', 'ProfileController@edit');
});
