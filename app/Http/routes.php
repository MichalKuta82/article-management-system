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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'user'], function(){

	Route::get('/user', function(){
		return view('user.index');
	});

	Route::resource('/articles', 'ArticleController');

	Route::patch('/articles/{id}/approve', 'ArticleController@approve');

	Route::resource('/comments', 'CommentController');
});