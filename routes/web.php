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


Route::group(['prefix' => 'calendar', 'middleware' => 'auth'], function() {
    Route::get('create', 'CalendarController@create');
    Route::post('create', 'CalendarController@update');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::redirect('/home', '/calendar/create', 301);
Route::redirect('/', '/calendar/create', 301);
