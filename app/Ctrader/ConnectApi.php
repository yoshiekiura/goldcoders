<?php

namespace App\Ctrader;

use GuzzleHttp\Client;

class ConnectApi
{
    const DOMAIN = 'spotware.com';

    const GRANT_REFRESH_TOKEN = 'refresh_token';

    const GRANT_TOKEN = 'authorization_code';

    const PROTOCOL = 'https://';

    const V1 = '/apps/';

    const V2 = '/oauth/v2/';

    /**
     * @var mixed
     */
    public $client_id;

    /**
     * @var mixed
     */
    public $client_secret;

    /**
     * @var mixed
     */
    public $endpoint;

    /**
     * @var string
     */
    public $grant_type;

    /**
     * @var mixed
     */
    public $redirect_uri;

    /**
     * @var mixed
     */
    public $scope;

    /**
     * @var mixed
     */
    public $subdomain;

    /**
     * @var string
     */
    public $version;

    /**
     * @param $segment = 'token|auth'
     */
    public function __construct($segment = 'token')
    {
        $this->client_id     = config('ctrader.client_id');
        $this->client_secret = config('ctrader.client_secret');
        $this->subdomain     = config('ctrader.connect_api');
        $this->version       = config('ctrader.version');
        $this->redirect_uri  = config('ctrader.redirect_url');
        $this->scope         = $this->getScope();
        $this->endpoint      = $this->getEndpoint($segment);
    }

    /**
     * @param  $data
     * @return mixed
     */
    public function encodeData($data)
    {
        return $data = [
            'data' => urlencode(base64_encode(json_encode($data)))
        ];
    }

    /**
     * @param $code
     */
    public function getAccessToken($code)
    {
        $params                  = [];
        $params['grant_type']    = static::GRANT_TOKEN;
        $params['code']          = $code;
        $params['redirect_uri']  = $this->redirect_uri;
        $params['client_id']     = $this->client_id;
        $params['client_secret'] = $this->client_secret;

        return $this->makeCall('GET', $this->endpoint, $params);
    }

    /**
     * @return mixed
     */
    public function getAuthorizationCodeLink()
    {
        $params                 = [];
        $params['client_id']    = $this->client_id;
        $params['redirect_uri'] = $this->redirect_uri;
        $params['scope']        = $this->scope;
        $query_string =$params['client_id'].'&redirect_uri='.$params['redirect_uri'].'&scope='.$params['scope'];
        return $this->endpoint.'?client_id='.$query_string;
    }

    /**
     *  $api = auth | token
     * @return mixed
     */
    public function getEndpoint($segment = 'auth')
    {
        $url = static::PROTOCOL.$this->subdomain.'.'.static::DOMAIN;

        if (1 == $this->version) {
            return $url.static::V1.$segment;
        }

        return $url.static::V2.$segment;
    }

    /**
     * @param $refresh_token
     */
    public function getRenewToken($refresh_token)
    {
        $params = [];

        $params['grant_type']    = $this->setGrantType(static::GRANT_REFRESH_TOKEN);
        $params['refresh_token'] = $refresh_token;
        $params['client_id']     = $this->client_id;
        $params['client_secret'] = $this->client_secret;
        $this->makeCall('GET', $this->endpoint, $params);
    }

    public function getScope()
    {
        return implode(', ', config('ctrader.scope'));
    }

    /**
     * @param  $method
     * @param  $uri
     * @param  $params
     * @return null
     */
    public function makeCall($method, $uri, $params)
    {
        $client   = new Client();
        $response = $client->request($method, $uri, ['query' => $params]);
        $data     = $response->getBody()->getContents();
        $data     = json_decode($data, true);
        return $data;
    }

    /**
     * @param $grant_type
     */
    public function setGrantType($grant_type)
    {
        $this->grant_type = $grant_type;
    }
}
