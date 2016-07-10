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
Route::get('{levelId}/topics', 'LevelController@indexTopics');

