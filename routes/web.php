<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login');
Route::get('logout')->name('logout')->uses('Auth\LoginController@showLogoutForm')->middleware('auth');
Route::post('logout')->name('logout.attempt')->uses('Auth\LoginController@logout')->middleware('auth');

Route::get('/')->name('dashboard')->uses('DashboardController')->middleware('auth');
Route::get('/members')->name('users.index')->uses('UsersController@index')->middleware('auth');
Route::get('/members/add')->name('users.add')->uses('UsersController@create')->middleware('auth');
Route::get('/members/{user}/edit')->name('users.edit')->uses('UsersController@edit')->middleware('auth');
Route::post('/members/{user}/update')->name('users.update')->uses('UsersController@update')->middleware('auth');
Route::post('/members/{user}/delete')->name('users.destroy')->uses('UsersController@destroy')->middleware('auth');
Route::post('/users/massDelete', 'UsersController@massDelete')->name('users.massDelete')->middleware('auth');
