<?php

namespace App;

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
     * @param $version
     */
    public function __construct($segment = 'auth')
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
        $params['grant_type']    = $this->setGrantType();
        $params['code']          = $code;
        $params['redirect_uri']  = $this->redirect_uri;
        $params['client_id']     = $this->client_id;
        $params['client_secret'] = $this->client_secret;
        $this->makeCall('GET', $this->endpoint, $params);
    }

    public function getAuthorizationCode()
    {
        $params                  = [];
        $params['client_id']     = $this->client_id;
        $params['client_secret'] = $this->client_secret;
        $params['redirect_uri']  = $this->redirect_uri;
        $params['scope']         = $this->scope;
        $this->makeCall('GET', $this->endpoint, $params);
    }

    /**
     *  $api = auth | token
     * @return mixed
     */
    public function getEndpoint($segment = 'auth')
    {
        $url = self::PROTOCOL.$this->subdomain.'.'.self::DOMAIN;

        if (1 == $this->version) {
            return $url.self::V1.$segment;
        }

        return $url.self::V2.$segment;
    }

    /**
     * @param $refresh_token
     */
    public function getRenewToken($refresh_token)
    {
        $params = [];

        $params['grant_type']    = $this->setGrantType(self::GRANT_REFRESH_TOKEN);
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
        $client   = new Client(['base_uri', self::DOMAIN]);
        $response = $client->request($method, $uri, $params);
        $data     = $response->getBody()->getContents();
        $data     = json_decode($data, true);
        return $data;
    }

    /**
     * @param $grant_type
     */
    public function setGrantType($grant_type = self::GRANT_TOKEN)
    {
        $this->grant_type = $grant_type;
    }
}
