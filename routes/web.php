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
Route::group(['middleware' => 'auth'], function() {
// Route::get('/home', 'HomeController@index')->name('home');


Route::resource('events', 'EventController');

Route::get('myevents/list', 'myEventController@listEventType');

Route::get('myevents/deleted-list', 'myEventController@listDeletedEvents');

Route::resource('myevents', 'myEventController');

Route::group(['middleware' => 'IsAdmin'], function() {

Route::get('users/list','AdminController@listUsers');

Route::resource('users','AdminController');

Route::post('/slots/{id}/{status}','SlotController@store');

Route::get('slots/booked','SlotController@listBookedSlots');

Route::resource('slots','SlotController');


});

});


