<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'dashboard';

    public function showLogoutForm()
    {
        return Inertia::render('Logout');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout','showLogoutForm']);
    }

    public function showLoginForm()
    {
        return Inertia::render('Login');
    }
}
