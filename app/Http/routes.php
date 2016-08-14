<?php
/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */
/**
 * DB query debugging
 */
DB::listen ( function ($sql) {
	// dump($sql->sql).PHP_EOL;
	// dump($sql->bindings).PHP_EOL;
	// dump($sql->time);
} );
/*
 * |--------------------------------------------------------------------------
 * | Front end routes
 * |--------------------------------------------------------------------------
 * |
 * |
 */
Route::get ( '/', 'HomeController@index' );
Route::resource ( 'topics', 'TopicController' );

/*
 * |--------------------------------------------------------------------------
 * | Admin routes
 * |--------------------------------------------------------------------------
 * |
 * |
 */
Route::get ( '/admin', function () {
	return view ( 'welcome' );
} );

// Authentication routes...
Route::auth ();

// Home page
Route::get ( '/home', 'HomeController@index' );
Route::get ( '/topic-delete/{id}', 'Api\V1\Admin\TopicController@destroy' );

/*
 * |--------------------------------------------------------------------------
 * | Admin API Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where all API routes are defined.
 * |
 */
Route::group ( [ 
		'prefix' => 'api/v1/admin',
		'namespace' => 'Api\V1\Admin' 
], function () {
	require app_path ( 'Http/api_v1_routes.php' );
} );

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
				'web',
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
		// List topics based on Product types
		Route::get ( 'product-types/{type}', 'TopicController@indexByLevel' );
	} );
} );
