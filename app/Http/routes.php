<?php
/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
/**
 * DB query debugging
 */
DB::listen(function($sql) {
   //dump($sql->sql).PHP_EOL;
//dump($sql->bindings).PHP_EOL;
//    dump($sql->time);
});
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes...
Route::auth();

// Home page
Route::get('/home', 'HomeController@index');
//Route::get('/api/v1/test', 'Api\UserAPIController@index');
/*
  |--------------------------------------------------------------------------
  | API routes
  |--------------------------------------------------------------------------
 */

Route::group(['prefix' => 'api', 'middleware' => ['auth:api', 'api.auth.isAdmin']],
    function () {
    Route::group(['prefix' => 'v1/admin', 'namespace' => 'Api\V1\Admin'],
        function () {
        //dump(Auth::guard('api')->user());
        require app_path('Http/api_v1_routes.php');
    });
});

Route::group(['middleware' => ['web'], 'prefix' => 'admin'], function () {
    Route::get('/', function() {
         return view('admin/layout');
    });
    
    //Dashboard Route
    Route::get('page', function() {
        return view('admin/layout');
    });
});