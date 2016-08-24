<?php

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | This file is where you may define all of the routes that are handled
 * | by your application. Just tell Laravel the URIs it should respond
 * | to using a Closure or controller method. Build something great!
 * |
 */
Route::get ( '/', 'WelcomeController@index');

Auth::routes ();

Route::get ( '/home', 'HomeController@index' );
/*
 * |--------------------------------------------------------------------------
 * | Admin Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where all admin routes are defined.
 * |
 */
Route::group ( [ 
		'middleware' => [ 
				
				'admin' 
		] 
], function () {
	// Admin Route
	Route::group ( [ 
			'prefix' => 'admin' 
	], function () {
		Route::get ( '/', function () {
			return view ( 'back/dashboard' );
		} );
		
		// Dashboard Route
		Route::get ( 'dashboard', function () {
			return view ( 'back/dashboard' );
		} );
		// Topics Route
		Route::resource ( 'topics', 'TopicController' );
		// Article Route
		Route::resource ( 'articles', 'ArticleController' );
		// List topics based on Product types
		Route::get ( 'product-types/{type}', 'TopicController@indexByLevel' );
	} );
} );

