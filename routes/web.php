<?php
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome');
});
Route::get('/login', function () {
    return Inertia::render('Login');
});
Route::get('/register', function () {
    return Inertia::render('Dashboard');
});
