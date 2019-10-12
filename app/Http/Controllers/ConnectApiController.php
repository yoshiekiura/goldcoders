<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Ctrader\ConnectApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ConnectApiController extends Controller
{
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
            $data            = $api->getAccessToken($request->code);
            $data['user_id'] = $user->id;
            return $data;
            // $user->ctrader()->save($data);
            // redirect to index
        }
    }

    public function view()
    {
        $user = Auth::user();
        $this->authorize('add_access_token', $user);
        return Inertia::render('Ctrader/Connect', [
            'account'     => Auth::user(),
        ]);
    }
}
