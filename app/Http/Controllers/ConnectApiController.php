<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Ctrader;
use App\Ctrader\ConnectApi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ConnectApiController extends Controller
{
    /**
     * @return null
     */
    public function connect()
    {
        $user = Auth::user();
        $this->authorize('add_access_token', $user);

        $api = new ConnectApi('auth');
        $url = $api->getAuthorizationCodeLink();
        return Redirect::to($url);
    }

    /**
     * @return mixed
     */
    public function redirect(Request $request)
    {
        $user = Auth::user();
        $this->authorize('add_access_token', $user);
        $api = new ConnectApi();

        if ($request->has('code')) {
            $data  = $api->getAccessToken($request->code);
            $token = $user->ctraderToken;

            if (!$token) {
                $ctrader = new Ctrader();
                $this->fillData($ctrader, $data);
                $user->ctraderToken()->save($ctrader);
                // return ['created' => true, 'ctrader' => $ctrader->fresh()];
                return redirect()->route('ctrader.view')->with('success', 'Ctrader Accounts Api Connected!');
            } else {
                $this->fillData($token, $data);
                $user->ctraderToken()->save($token);
                // return ['modify_permission' => true, 'ctrader' => $user->ctraderToken];
                return redirect()->route('ctrader.view')->with('success', 'Ctrader Accounts Api Modified');
            }
        }
    }

    /**
     * @return mixed
     */
    public function refreshToken()
    {
        $user = Auth::user();
        $this->authorize('add_access_token', $user);
        $api     = new ConnectApi('token');
        $data    = $api->getRenewToken($user->ctraderToken->refresh_token);
        $ctrader = $user->ctraderToken;
        $this->fillData($ctrader, $data);
        $user->ctraderToken()->save($ctrader);
        // return ['renew' => true, 'ctrader' => $user->ctraderToken];
        return redirect()->route('ctrader.view')->with('success', 'Ctrader Token Refresh!');
    }

    public function view()
    {
        $user    = Auth::user();
        $ctrader = $user->ctraderToken;
        $this->authorize('add_access_token', $user);
        return Inertia::render('Ctrader/Connect', [
            'account' => Auth::user(),
            'expired' => optional($ctrader)->isExpired() ? true : false
        ]);
    }

    /**
     * @param $ctrader
     * @param $data
     */
    protected function fillData($ctrader, $data)
    {
        $ctrader->access_token  = $data['access_token'];
        $ctrader->refresh_token = $data['refresh_token'];
        $ctrader->expires_in    = Carbon::parse($data['expires_in'])->setTimeZone(config('app.timezone'));
        $ctrader->token_type    = $data['tokenType'];
    }
}
