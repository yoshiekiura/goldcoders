<?php
return [
    'client_id'             => env('CTRADER_CLIEND_ID'),
    'client_secret'         => env('CTRADER_CLIENT_SECRET'),
    'live'                  => env('CTRADER_LIVE'),
    'protocol'              => env('CTRADER_PROTOCOL', 'https://'),
    'domain'                => env('CTRADER_DOMAIN', 'spotware.com'),
    'accounts_api'          => env('CTRADER_LIVE') === false ? 'sandbox-api' : 'api',
    'connect_api'           => env('CTRADER_LIVE') === false ? 'sandbox-connect' : 'connect',
    'trading_api'           => env('CTRADER_LIVE') === false ? 'sandbox-tradeapi' : 'tradeapi',
    'trading_proxy_port'    => 5032,
    'trading_proxy_country' => env('CTRADER_PROXY', 'hk'),
    'version'               => env('CTRADER_VERSION', 2),
    'scope'                 => [
        'accounts',
        // 'trading'
    ],
    'drpm'                  => 180, //   deals request/min
    'rpm'                   => 30,  // other request/min
    'redirect_url'          => env('CTRADER_REDIRECT_URI')
];
