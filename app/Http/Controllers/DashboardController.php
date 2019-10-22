<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        $roles = $user->roles()->get();
        $data = $roles->implode('name', ',');
        $contains = Str::contains($data, ['paymaster', 'admin']);



        // return $user->verifiedpayouts()->get();
        // return $user->payouts->get();

        if ($contains) {
            return Inertia::render('Dashboard');
        } else {
            return Inertia::render('Dashboard',  [
                'subscription_count' => '1',
                'subscription_verified' => '2',
                'referrals_total' => $user->referrals->count(),
                'kyc_verified' => $user->active,
                'payment_total' => $user->payments->sum('amount'),
                'payout_request_total' => $user->payouts()->verifiedPayouts()->get()->sum('amount'),
            ]);
        }
    }
}
