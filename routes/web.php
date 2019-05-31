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

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');


Route::resource('events', 'EventController');

Route::get('myevents/list', 'myEventController@listEventType');

Route::get('myevents/deleted-list', 'myEventController@listDeletedEvents');

Route::resource('myevents', 'myEventController')->middleware('auth');



