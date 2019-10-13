<?php

namespace App\Http\Controllers;

use App\Ctrader\AccountsApi;
use Illuminate\Support\Facades\Auth;

class AccountsApiController extends Controller
{
    // todo add filter for customizing the return data set
    // todo save to database
    // todo method to check whether to add new dataset to database
    // todo method to reset database

    /**
     * @var mixed
     */
    public $api;

    /**
     * @var mixed
     */
    public $token;

    /**
     * @param AccountsApi $api
     */
    public function __construct(AccountsApi $api)
    {
        $this->api = $api;
        $this->middleware(function ($request, $next) {
            $this->token = optional(Auth::user()->ctraderToken)->access_token;

            return $next($request);
        });
    }

    /**
     * @param  $trading_account_1id
     * @return mixed
     */
    public function getAccount($trading_account_id)
    {
        return $this->api->token($this->token)->getAccount($trading_account_id)->makeCall();
    }

    /**
     * @return mixed
     */
    public function getAccounts()
    {
        // save to trading_accounts db $result['data'];
        return $this->api->token($this->token)->getAccounts()->makeCall();
    }

    /**
     * @param  $trading_account_id
     * @return mixed
     */
    public function getCashFlow($trading_account_id)
    {
        return $this->api->token($this->token)->getCashFlow($trading_account_id)->makeCall();
    }
}
