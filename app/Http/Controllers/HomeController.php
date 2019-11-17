<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Gateway;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as ValidateRequest;

class HomeController extends Controller
{

    public function home()
    {
        return Inertia::render('FrontPage/Home/Index', [
            'url' => url('/'),
        ]);
    }

    public function faq()
    {
    }

}
