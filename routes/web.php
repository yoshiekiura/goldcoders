<?php

Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login');
Route::get('logout')->name('logout')->uses('Auth\LoginController@showLogoutForm')->middleware('auth');
Route::post('logout')->name('logout.attempt')->uses('Auth\LoginController@logout')->middleware('auth');

Route::get('/')->name('dashboard')->uses('DashboardController')->middleware('auth');
Route::get('/members')->name('users.index')->uses('UsersController@index')->middleware('remember', 'auth', 'role:admin');
Route::get('/members/create')->name('users.create')->uses('UsersController@create')->middleware('auth', 'role:admin');
Route::post('/members/store')->name('users.store')->uses('UsersController@store')->middleware('auth', 'role:admin');
Route::get('/members/{user}/edit')->name('users.edit')->uses('UsersController@edit')->middleware('auth', 'role:admin');
Route::post('/members/{user}/update')->name('users.update')->uses('UsersController@update')->middleware('auth', 'role:admin');
Route::post('/members/{user}/destroy')->name('users.destroy')->uses('UsersController@destroy')->middleware('auth', 'role:admin');
Route::post('/users/massDelete', 'UsersController@massDelete')->name('users.massDelete')->middleware('auth', 'role:admin');
Route::post('/users/toggleStatus', 'UsersController@toggleStatus')->name('users.toggleStatus')->middleware('auth', 'role:admin');
Route::post('/users/massActivate', 'UsersController@massActivate')->name('users.massActivate')->middleware('auth', 'role:admin');
Route::post('/users/massDeactivate', 'UsersController@massDeactivate')->name('users.massDeactivate')->middleware('auth', 'role:admin');
Route::post('/users/massMail', 'UsersController@massMail')->name('users.massMail')->middleware('auth', 'role:admin');

//Referrals
Route::get('/referrals/{user?}')->name('referrals.index')->uses('UsersController@referrals')->middleware('remember', 'auth');
// Paymaster
Route::get('/paymaster-user-management')->name('paymaster.index')->uses('UsersController@paymasterIndex')->middleware('remember', 'auth', 'role:paymaster');
// Profile Page
Route::get('/profile')->name('profile.show')->uses('ProfileController@show')->middleware('remember', 'auth');
Route::post('/profile/update')->name('profile.update')->uses('ProfileController@update')->middleware('remember', 'auth');
Route::get('/kyc')->name('kyc.show')->uses('KycController@show')->middleware('remember', 'auth');
Route::post('/kyc/uploads')->name('kyc.uploads')->uses('KycController@uploads')->middleware('auth');

Route::get('/gateway')->name('gateway')->uses('GatewayController@index')->middleware('auth', 'role:admin');
Route::get('/gateway/create')->name('gateway.create')->uses('GatewayController@create')->middleware('auth', 'role:admin|paymaster');
Route::post('/gateway')->name('gateway.store')->uses('GatewayController@store')->middleware('auth', 'role:admin|paymaster');
Route::post('/gateway/delete')->name('gateway.delete')->uses('GatewayController@delete')->middleware('auth', 'role:admin');
Route::get('/gateway/{gateway}/edit')->name('gateway.edit')->uses('GatewayController@edit')->middleware('auth', 'role:admin');
Route::post('/gateway/update')->name('gateway.update')->uses('GatewayController@update')->middleware('auth', 'role:admin');

Route::get('/payment')->name('payment')->uses('PaymentController@index');
Route::get('/payment/create')->name('payment.create')->uses('PaymentController@create');
Route::post('/payment')->name('payment.store')->uses('PaymentController@store');
Route::post('/payment/delete')->name('payment.delete')->uses('PaymentController@delete');
Route::get('/payment/{payment}/edit')->name('payment.edit')->uses('PaymentController@edit');
Route::post('/payment/update')->name('payment.update')->uses('PaymentController@update');
Route::get('/payment/{payment}/view')->name('payment.view')->uses('PaymentController@view');

Route::get('/getPaymasterMembers/{user}')->name('getPaymasterMembers')->uses('PaymentController@getPaymasterMembers');

Route::get('/payout')->name('payout')->uses('PayoutController@index')->middleware('auth');
Route::get('/payout/create')->name('payout.create')->uses('PayoutController@create')->middleware('auth');
Route::post('/payout')->name('payout.store')->uses('PayoutController@store')->middleware('auth');
Route::post('/payout/delete')->name('payout.delete')->uses('PayoutController@delete')->middleware('auth');
Route::get('/payout/{payout}/edit')->name('payout.edit')->uses('PayoutController@edit')->middleware('auth');
Route::post('/payout/update')->name('payout.update')->uses('PayoutController@update')->middleware('auth');
Route::get('/payout/{payout}/view')->name('payout.view')->uses('PayoutController@view')->middleware('auth');

Route::get('/approval')->name('approval')->uses('ApprovalController@index')->middleware('auth');
Route::get('/approval_payout')->name('approval.payout')->uses('ApprovalController@payout')->middleware('auth');
Route::post('/approval_payout_approved/{payout}')->name('approval.payout.approved')->uses('ApprovalController@payout_approved')->middleware('auth');
Route::post('/approval_payout_disapproved/{payout}')->name('approval.payout.disapproved')->uses('ApprovalController@payout_disapproved')->middleware('auth');
Route::get('/approval_payment')->name('approval.payment')->uses('ApprovalController@payment')->middleware('auth');
Route::post('/approval_payment_approved/{payment}')->name('approval.payment.approved')->uses('ApprovalController@payment_approved')->middleware('auth');
Route::post('/approval_payment_disapproved/{payment}')->name('approval.payment.disapproved')->uses('ApprovalController@payment_disapproved')->middleware('auth');
Route::get('/approval_user_file')->name('approval.user.file')->uses('ApprovalController@user_file')->middleware('auth');
Route::post('/approval_user_file_approved/{file}')->name('approval.user.file.approved')->uses('ApprovalController@user_file_approved')->middleware('auth');
Route::post('/approval_user_file_disapproved/{file}')->name('approval.user.file.disapproved')->uses('ApprovalController@user_file_disapproved')->middleware('auth');

Route::get('/contract_manager')->name('contract_manager')->uses('ContractManagerController@index')->middleware('auth');

Route::get('/admin_file_manager')->name('admin_file_manager')->uses('AdminFileManagerController@index')->middleware('auth', 'role:admin');
Route::get('/admin_file_manager/create')->name('admin_file_manager.create')->uses('AdminFileManagerController@create')->middleware('auth', 'role:admin');
Route::post('/admin_file_manager')->name('admin_file_manager.store')->uses('AdminFileManagerController@store')->middleware('auth', 'role:admin');
Route::post('/admin_file_manager/delete')->name('admin_file_manager.delete')->uses('AdminFileManagerController@delete')->middleware('auth', 'role:admin');
Route::get('/admin_file_manager/{admin_file_manager}/edit')->name('admin_file_manager.edit')->uses('AdminFileManagerController@edit')->middleware('auth', 'role:admin');
Route::post('/admin_file_manager/update')->name('admin_file_manager.update')->uses('AdminFileManagerController@update')->middleware('auth', 'role:admin');

Route::get('/user_file_manager/view_downloadable_files')->name('view_downloadable_files')->uses('UserFileManagerController@view_downloadable_files')->middleware('auth');
Route::get('/user_file_manager/{admin_file_manager}/download_files')->name('download_files')->uses('UserFileManagerController@download_files')->middleware('auth');

Route::get('/user_file_manager')->name('user_file_manager')->uses('UserFileManagerController@index')->middleware('auth');
Route::get('/user_file_manager/create')->name('user_file_manager.create')->uses('UserFileManagerController@create')->middleware('auth');
Route::post('/user_file_manager')->name('user_file_manager.store')->uses('UserFileManagerController@store')->middleware('auth');
Route::post('/user_file_manager/delete')->name('user_file_manager.delete')->uses('UserFileManagerController@delete')->middleware('auth');
Route::get('/user_file_manager/{user_file_manager}/edit')->name('user_file_manager.edit')->uses('UserFileManagerController@edit')->middleware('auth');
Route::post('/user_file_manager/update')->name('user_file_manager.update')->uses('UserFileManagerController@update')->middleware('auth');
Route::get('/user_file_manager/{user_file_manager}/view')->name('user_file_manager.view')->uses('UserFileManagerController@view')->middleware('auth');


// return a view that user can click to redirect to ctrader login and allow our app permission
Route::get('/ctrader/auth')->name('ctrader.connect')->uses('ConnectApiController@connect')->middleware('auth', 'role:admin|paymaster');
// this url will receive our authorization code that we can use to get access token
Route::get('/ctrader/connect/redirect')->name('ctrader.redirect')->uses('ConnectApiController@redirect')->middleware('auth', 'role:admin|paymaster');
Route::get('/ctrader/connect')->name('ctrader.view')->uses('ConnectApiController@view')->middleware('auth', 'role:admin|paymaster');
Route::get('/ctrader/connect/refresh_token')->name('ctrader.refresh_token')->uses('ConnectApiController@refreshToken')->middleware('auth', 'role:admin|paymaster');

Route::get('/ctrader/getAccounts')->name('ctrader.getAccounts')->uses('AccountsApiController@getAccounts')->middleware('auth', 'role:admin|paymaster');
Route::get('/ctrader/account/{trading_account_id}/get-cash-flow')->name('ctrader.getCashFlow')->uses('AccountsApiController@getCashFlow')->middleware('auth', 'role:admin|paymaster');
// url for viewing ctrader accounts
// for paymaster only
Route::get('/ctrader/accounts')->name('ctrader.accounts.index')->uses('AccountsApiController@index')->middleware('auth', 'role:paymaster', 'remember');
// for admin
// this route is not yet existing
Route::get('/ctrader/accounts/{paymaster_id}')->name('ctrader.paymaster.accounts')->uses('AccountsApiController@view')->middleware('auth', 'role:admin');

Route::get('/ctrader/updateAllAccounts')->name('ctrader.updateAllAccounts')->uses('AccountsApiController@updateAllAccounts')->middleware('auth');
Route::get('/ctrader/account/{trading_account_id}/getAccount')->name('ctrader.getAccount')->uses('AccountsApiController@getAccount')->middleware('auth');
Route::get('/ctrader/account/{trading_account_id}/trading-history')->name('ctrader.tradinghistory')->uses('AccountsApiController@getDeals')->middleware('auth');
Route::get('/ctrader/account/{trading_account_id}/cashflow')->name('ctrader.getCashFlow')->uses('AccountsApiController@getCashFlow')->middleware('auth');
Route::get('/ctrader/account/{trading_account_id}/getSymbols')->name('ctrader.getSymbols')->uses('AccountsApiController@getSymbols')->middleware('auth');
