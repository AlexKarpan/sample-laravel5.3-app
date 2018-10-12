<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes(); // TODO: remove 'register' routes


Route::get('/', function () {
	if(Auth::guest()) {

		// default booking page for guests
		return redirect('/book');
	} else {

		// would be an admin dashboard in real app
		return redirect('/booking');
	}
});


// guest routes

Route::get('book', 'ScheduleController@showForm');
Route::post('book', 'ScheduleController@schedule');
Route::get('book/thank-you/{id}', 'ScheduleController@showThankYouPage');


// admin routes

Route::group([
	'middleware' => 'auth',
	'namespace' => 'Admin',
	], function() {

	Route::resource('customer', 'CustomerController');
	Route::resource('booking', 'BookingController');
	Route::resource('cleaner', 'CleanerController');
	Route::resource('cities', 'CityController', ['except' => [ 'show' ]]);

});

