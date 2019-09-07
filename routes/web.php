<?php

Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login');
Route::get('logout')->name('logout')->uses('Auth\LoginController@showLogoutForm')->middleware('auth');
Route::post('logout')->name('logout.attempt')->uses('Auth\LoginController@logout')->middleware('auth');

Route::get('/')->name('dashboard')->uses('DashboardController')->middleware('auth');
Route::get('/members')->name('users.index')->uses('UsersController@index')->middleware('auth');
Route::get('/members/create')->name('users.create')->uses('UsersController@create')->middleware('auth');
Route::post('/members/store')->name('users.store')->uses('UsersController@store')->middleware('auth');
Route::get('/members/{user}/edit')->name('users.edit')->uses('UsersController@edit')->middleware('auth');
Route::post('/members/{user}/update')->name('users.update')->uses('UsersController@update')->middleware('auth');
Route::post('/members/{user}/destroy')->name('users.destroy')->uses('UsersController@destroy')->middleware('auth');
Route::post('/users/massDelete', 'UsersController@massDelete')->name('users.massDelete')->middleware('auth');
Route::post('/users/toggleStatus', 'UsersController@toggleStatus')->name('users.toggleStatus')->middleware('auth');
Route::post('/users/massActivate', 'UsersController@massActivate')->name('users.massActivate')->middleware('auth');
Route::post('/users/massDeactivate', 'UsersController@massDeactivate')->name('users.massDeactivate')->middleware('auth');
Route::post('/users/massDelete', 'UsersController@massDelete')->name('users.massDelete')->middleware('auth');
Route::post('/users/massMail', 'UsersController@massMail')->name('users.massMail')->middleware('auth');

// routes for profile, settings, change password
