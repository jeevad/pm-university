<?php
/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where all API routes are defined.
  |
 */
Route::resource('topics', 'TopicController');
Route::get('{levelId}/topics', 'TopicController@indexByLevel');
Route::get('topic/{topicId}', 'TopicController@show');
Route::get('topic/{topicId}/tag/{tagId}', 'ContentController@indexByTag');

