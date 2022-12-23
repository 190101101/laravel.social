<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');

/*auth*/
// Route::get('/signup', 'AuthController@getSignup')->name('auth.signup')->middleware('guest');
// Route::post('/signup', 'AuthController@postSignup')->middleware('guest');
Route::post('/signup', 'AuthController@postSignup')->name('auth.signup')->middleware('guest');

// Route::get('/signin', 'AuthController@getSignin')->name('auth.signin')->middleware('guest');
// Route::post('/signin', 'AuthController@postSignin')->middleware('guest');
Route::post('/signin', 'AuthController@postSignin')->name('auth.signin')->middleware('guest');
Route::get('/signout', 'AuthController@signout')->name('auth.signout')->middleware('auth');

Route::get('/alert', function(){
	return redirect()->route('home')->with('info', 'you can log in');
});


Route::get('/search', 'SearchController@getResults')->name('search.results');

/**/
Route::get('/user/{username}', 'ProfileController@getProfile')->name('profile.index');
Route::get('/profile/edit', 'ProfileController@getEdit')->middleware('auth')->name('profile.edit');
Route::post('/profile/edit', 'ProfileController@postEdit')->middleware('auth')->name('profile.edit');

/**/
Route::get('/friends', 'FriendController@getIndex')->middleware('auth')->name('friend.index');
Route::get('/friends/add/{username}', 'FriendController@getAdd')->middleware('auth')->name('friend.add');
Route::get('/friends/accept/{username}', 'FriendController@getAccept')->middleware('auth')->name('friend.accept');
Route::post('/friends/delete/{username}', 'FriendController@deleteFriend')->middleware('auth')->name('friend.delete');

/**/
Route::post('/status', 'StatusController@postStatus')->middleware('auth')->name('status.post');
Route::post('/status/{statusId}/reply', 'StatusController@postReply')->middleware('auth')->name('status.reply');


Route::get('/status/{statusId}/like', 'StatusController@getLike')->middleware('auth')->name('status.like');
