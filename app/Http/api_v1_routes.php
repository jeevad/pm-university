<?php
/*
 * |--------------------------------------------------------------------------
 * | API Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where all API routes are defined.
 * |
 */
Route::get('{levelId}/topics', 'TopicController@indexByLevel');
Route::resource('topics', 'TopicController');
Route::get('topic/{topicId}/tag/{tagId}', 'ContentController@indexByTag');
Route::post('articles', 'ArticleController@store');

