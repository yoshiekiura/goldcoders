<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Ctrader;
use App\Ctrader\AccountsApi;
use App\Models\CtraderAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

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
        // return an inertia response with table
    }

    /**
     * @return mixed
     */
    public function getAccounts($paymaster_id = null)
    {
        // go first to /ctrader/auth then hit this url to update all accounts
        $user    = Auth::user();
        $user_id = $user->id;

        if ($paymaster_id) {
            $this->authorize('manage_user', $user);
            $user        = User::find($paymaster_id);
            $user_id     = $user->id;
            $this->token = $user->CtraderToken->access_token;
        }

        $results    = $this->api->token($this->token)->getAccounts()->makeCall();
        $collection = collect($results['data']);

        $accounts = $collection->when(config('app.env') === false, function ($collection) {
            return $collection->where('live', false);
        })->when(config('app.env') === true, function ($collection) {
            return $collection->where('live', true);
        })->map(function ($item) use ($user_id) {
            $item['paymaster_id'] = $user_id;
            $item['traderRegistrationTimestamp'] = intval($item['traderRegistrationTimestamp'])/1000;
            return $item;
        })->toArray();
        // delete all Old Record
        CtraderAccount::where('paymaster_id', $user_id)->delete();
        // Insert New Record
        CtraderAccount::insert($accounts);
        // Retrive Records
        return CtraderAccount::where('paymaster_id', $user_id)->get();
    }

    /**
     * @param  $trading_account_id
     * @return mixed
     */
    public function getCashFlow($trading_account_id)
    {
        return $this->api->token($this->token)->getCashFlow($trading_account_id)->makeCall();
    }

    public function index()
    {
        $user = Auth::user();

        $per_page = 10;

        if (request()->per_page && is_int(intval(request()->per_page)) && request()->per_page > 0) {
            $per_page = intval(request()->per_page);
        }

        return Inertia::render('Ctrader/Index', [
            'paymaster' => $user,
            'filters'   => Request::all('search', 'broker', 'leverage', 'currency', 'live', 'demo', 'status', 'page', 'per_page'),
            'per_page'  => $per_page,
            'accounts'  => CtraderAccount::where('paymaster_id', $user->id)
                ->filter(Request::only('search', 'broker', 'leverage', 'currency', 'live', 'demo', 'status'))
                ->paginate($per_page)
                ->transform(function ($account) {
                    return [
                        'id'                => $account->accountId,
                        'account_no'        => $account->accountNumber,
                        'broker_name'       => $account->brokerName,
                        'broker_title'      => $account->brokerTitle,
                        'live'              => $account->live,
                        'currency'          => $account->depositCurrency,
                        'leverage'          => $account->leverage,
                        'balance'           => $account->balance,
                        'status'            => $account->AccountStatus,
                        'deleted'           => $account->deleted,
                        'swap_free'         => $account->swapFree,
                        'type'              => $account->traderAccountType,
                        'registration_date' => $account->traderRegistrationTimestamp
                    ];
                })
        ]);
    }

    /**
     * This Should be Call on Cron at Daily Interval midnight
     * @param Request $request
     */
    public function updateAllAccounts()
    {
        $ids  = Ctrader::all()->pluck('user_id')->toArray();
        $data = [];

        foreach ($ids as $id) {
            $accounts = $this->getAccounts($id);
            array_push($data, $accounts);
            // call the getAccounts and attach paymaster_id in request
        }

        // this is just for verifaction we are calling it multiple times
        return $data;
    }
}
