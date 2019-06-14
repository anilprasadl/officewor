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





// Route::resource('home', 'HomeController');

Auth::routes();

Auth::routes(['verify' => true]);

Route::get('/', function () {
})->middleware('verified');

Route::get('/', function () {
    return view('welcome');

});





Route::resource('events', 'EventController');



Route::group(['middleware' => 'auth'], function() {

Route::get('/changePassword','HomeController@showChangePasswordForm');

Route::post('/changePassword','HomeController@changePassword')->name('changePassword');

Route::get('myevents/list', 'myEventController@listEventType');

Route::get('task-track/list', 'myEventController@listAllTask');

Route::get('/task-track/{id}', 'myEventController@taskInfo');

Route::get('task-track', 'myEventController@display');

Route::get('myevents/deleted-list', 'myEventController@listDeletedEvents');

Route::resource('myevents', 'myEventController');

Route::group(['middleware' => 'IsAdmin'], function() {

Route::group(['middleware' => 'IsSuperUser'], function() {  

Route::get('users/list','AdminController@listUsers');

Route::get('admin/list','AdminController@listAdmin');

Route::resource('users','AdminController');

});

Route::get('/tasks/{id}','SlotController@taskAssign');

Route::post('/saveTasks','SlotController@saveTasks');

Route::post('/slots/{id}/{status}','SlotController@store');

Route::get('slots/booked','SlotController@listBookedSlots');

Route::resource('slots','SlotController');


});

});
