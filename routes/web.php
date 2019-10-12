<?php

Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login');
Route::get('logout')->name('logout')->uses('Auth\LoginController@showLogoutForm')->middleware('auth');
Route::post('logout')->name('logout.attempt')->uses('Auth\LoginController@logout')->middleware('auth');

Route::get('/')->name('dashboard')->uses('DashboardController')->middleware('auth');
Route::get('/members')->name('users.index')->uses('UsersController@index')->middleware('remember', 'auth');
Route::get('/members/create')->name('users.create')->uses('UsersController@create')->middleware('auth');
Route::post('/members/store')->name('users.store')->uses('UsersController@store')->middleware('auth');
Route::get('/members/{user}/edit')->name('users.edit')->uses('UsersController@edit')->middleware('auth');
Route::post('/members/{user}/update')->name('users.update')->uses('UsersController@update')->middleware('auth');
Route::post('/members/{user}/destroy')->name('users.destroy')->uses('UsersController@destroy')->middleware('auth');
Route::post('/users/massDelete', 'UsersController@massDelete')->name('users.massDelete')->middleware('auth');
Route::post('/users/toggleStatus', 'UsersController@toggleStatus')->name('users.toggleStatus')->middleware('auth');
Route::post('/users/massActivate', 'UsersController@massActivate')->name('users.massActivate')->middleware('auth');
Route::post('/users/massDeactivate', 'UsersController@massDeactivate')->name('users.massDeactivate')->middleware('auth');
Route::post('/users/massMail', 'UsersController@massMail')->name('users.massMail')->middleware('auth');

//Referrals
Route::get('/referrals/{user?}')->name('referrals.index')->uses('UsersController@referrals')->middleware('remember', 'auth');
// Paymaster
Route::get('/paymaster-user-management')->name('paymaster.index')->uses('UsersController@paymasterIndex')->middleware('remember', 'auth');
// Profile Page
Route::get('/profile')->name('profile.show')->uses('ProfileController@show')->middleware('remember', 'auth');
Route::post('/profile/update')->name('profile.update')->uses('ProfileController@update')->middleware('remember', 'auth');
Route::get('/kyc')->name('kyc.show')->uses('KycController@show')->middleware('remember', 'auth');
Route::post('/kyc/uploads')->name('kyc.uploads')->uses('KycController@uploads')->middleware('auth');

Route::get('/gateway')->name('gateway')->uses('GatewayController@index');
Route::get('/gateway/create')->name('gateway.create')->uses('GatewayController@create');
Route::post('/gateway')->name('gateway.store')->uses('GatewayController@store');
Route::post('/gateway/delete')->name('gateway.delete')->uses('GatewayController@delete');
Route::get('/gateway/{gateway}/edit')->name('gateway.edit')->uses('GatewayController@edit');
Route::post('/gateway/update')->name('gateway.update')->uses('GatewayController@update');

Route::get('/payment')->name('payment')->uses('PaymentController@index');
Route::get('/payment/create')->name('payment.create')->uses('PaymentController@create');
Route::post('/payment')->name('payment.store')->uses('PaymentController@store');
Route::post('/payment/delete')->name('payment.delete')->uses('PaymentController@delete');
Route::get('/payment/{payment}/edit')->name('payment.edit')->uses('PaymentController@edit');
Route::post('/payment/update')->name('payment.update')->uses('PaymentController@update');
Route::get('/getPaymasterMembers/{user}')->name('getPaymasterMembers')->uses('PaymentController@getPaymasterMembers');

// return a view that user can click to redirect to ctrader login and allow our app permission
Route::get('/ctrader/auth')->name('ctrader.connect')->uses('ConnectApiController@connect');
// this url will receive our authorization code that we can use to get access token
Route::get('/ctrader/connect/redirect')->name('ctrader.redirect')->uses('ConnectApiController@redirect');
Route::get('/ctrader')->name('ctrader.view')->uses('ConnectApiController@view');
Route::get('/ctrader/refresh_token')->name('ctrader.refresh_token')->uses('ConnectApiController@refreshToken');

