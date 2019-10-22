<?php

namespace App\Ctrader;

use GuzzleHttp\Client;

class AccountsApi
{
    const DOMAIN = 'spotware.com';

    const GRANT_REFRESH_TOKEN = 'refresh_token';

    const GRANT_TOKEN = 'authorization_code';

    const PROTOCOL = 'https://';

    const URL_SEGMENT = '/connect/';

    /**
     * @var mixed
     */
    public $access_token;

    /**
     * @var mixed
     */
    public $args;

    /**
     * @var mixed
     */
    public $endpoint;

    /**
     * @var mixed
     */
    public $subdomain;

    /**
     * @var mixed
     */
    public $uri;

    /**
     * @param $uri = profile|tradingaccounts
     */
    public function __construct()
    {
        $this->subdomain = config('ctrader.accounts_api');
        $this->endpoint  = $this->getEndpoint();
    }

    /**
     * @param $cursor
     */
    public function cursor($cursor)
    {
        $params = [
            'cursor' => $cursor
        ];
        $this->setParams($params);
        return $this;
    }

    /**
     * @param $time
     */
    public function from($time)
    {
        // we use milliseconds for timestamp
        $param  = \Carbon\Carbon::parse($time * 1000)->timestamp;
        $params = [
            'setTimeStampFrom' => $param
        ];
        $this->setParams($params);
        return $this;
    }

    /**
     * @param  $ctrader_id
     * @return mixed
     */
    public function getAccount($trading_account_id)
    {
        $this->uri = $this->endpoint.'tradingaccounts/'.$trading_account_id.'/deals';
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccounts()
    {
        $this->uri = $this->endpoint.'tradingaccounts';
        return $this;
    }

    /**
     * @param  $trading_account_id
     * @return mixed
     */
    public function getCashFlow($trading_account_id)
    {
        $this->uri = $this->endpoint.'tradingaccounts/'.$trading_account_id.'/cashflowhistory';
        return $this;
    }

    /**
     *  $api = auth | token
     * @return mixed
     */
    public function getEndpoint()
    {
        return static::PROTOCOL.$this->subdomain.'.'.static::DOMAIN.static::URL_SEGMENT;
    }

    /**
     * @param $trading_account_id
     */
    public function getSymbols($trading_account_id)
    {
        $this->uri = $this->endpoint.'tradingaccounts/'.$trading_account_id.'/symbols';
        return $this;
    }

    /**
     * @param $limit
     */
    public function limit($limit)
    {
        $params = [
            'limit' => $limit
        ];
        $this->setParams($params);
        return $this;
    }

    /**
     * @param  $method
     * @param  $uri
     * @param  $params   == $this->args
     * @return null
     */
    public function makeCall($method = null, $uri = null, $params = null)
    {
        if (null === $method) {
            $method = 'GEt';
        }

        if (null === $uri) {
            $uri = $this->uri;
        }

        if (null === $params) {
            $params = $this->args;
        }

        $client   = new Client();
        $response = $client->request($method, $uri, ['query' => $params]);
        $data     = $response->getBody()->getContents();
        $data     = json_decode($data, true);
        return $data;
    }

    /**
     * @param $params
     */
    public function setParams($params)
    {
        foreach ($params as $key => $value) {
            $this->args[$key] = $value;
        }
    }

    /**
     * @param $time
     */
    public function to($time)
    {
        $time   = \Carbon\Carbon::parse($time)->timestamp;
        $param  = intval($time.'000');
        $params = [
            'setTimeStampTo' => $param
        ];
        $this->setParams($params);
        return $this;
    }

    /**
     * @param  $token
     * @return mixed
     */
    public function token($token)
    {
        $params = [
            'access_token' => $token
        ];
        $this->setParams($params);
        return $this;
    }
}
