<?php

namespace App;

use GuzzleHttp\Client;

class Ctrader
{
    /**
     * @var string
     */
    public $TRACK_ONCE_KEY = '__track_once__';

    /**
     * @var mixed
     */
    public $api_key;

    /**
     * @var mixed
     */
    public $api_version;

    /**
     * @var mixed
     */
    public $custom_props;

    /**
     * @var mixed
     */
    public $customer_properties;

    /**
     * @var mixed
     */
    public $email;

    /**
     * @var mixed
     */
    public $endpoint;

    /**
     * @var mixed
     */
    public $event;

    /**
     * @var mixed
     */
    public $filters;

    /**
     * @var mixed
     */
    public $host;

    /**
     * @var mixed
     */
    public $properties;

    /**
     * @var mixed
     */
    public $props;

    /**
     * @var mixed
     */
    public $request_option;

    /**
     * @var string
     */
    public $tag = '$';

    /**
     * @var mixed
     */
    public $time;

    /**
     * @var mixed
     */
    public $token;

    /**
     * @var mixed
     */
    public $track_once_enable;
    public function __construct()
    {
        $this->client = new Client();
    }
    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function addCustomProps($key, $value)
    {
        return $this->custom_props[$key] = $value;
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function addCustomerProperties($key, $value)
    {
        return $this->customer_properties[$key] = $value;
    }

    /**
     * @param $args
     * @return mixed
     */
    public function addCustomerPropertyParams($args)
    {
        return $args = array_add($args, 'customer_properties', $this->getCustomerProperties());
    }

    /**
     * @param $args
     * @return mixed
     */
    public function addEventParam($args)
    {
        return $args = array_add($args, 'event', $this->getEvent());
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function addFilters($key, $value)
    {
        return $this->filters[$key] = $value;
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function addProperties($key, $value)
    {
        return $this->properties[$key] = $value;
    }

    /**
     * @param $args
     * @return mixed
     */
    public function addPropertyParams($args)
    {
        return $args = array_add($args, 'properties', $this->getProperties());
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function addProps($key, $value)
    {
        return $this->props[$key] = $value;
    }

    /**
     * @param $args
     * @return mixed
     */
    public function addTimeParams($args)
    {
        return $args = array_add($args, 'time', $this->getTime());
    }

    // this is useful for profiles
    /**
     * @return mixed
     */
    public function buildArgs()
    {
        // this will get the Api Args
        $args = $this->getBaseArg();
        // Special Arg , the one with $ prefix except, object and ID

        $attributes = $this->getProps();

        if (!null === $attributes) {
            foreach ($attributes as $key => $value) {
                $args = array_add($args, $key, $value);
            }
        }

        // Custom Args , the One We Create On the Fly
        $custom = $this->getCustomProps();

        if (!null === $custom) {
            foreach ($custom as $key => $value) {
                $args = array_add($args, $key, $value);
            }
        }

        // Filter Args

        $filters = $this->getFilters();

        if (!null === $filters) {
            foreach ($filters as $key => $value) {
                $args = array_add($args, $key, $value);
            }
        }

        // Return All Args
        return $args;
    }

    // We Use this For Server Side Track and Track Once Api
    /**
     * @param $data
     * @return mixed
     */
    public function encodeData($data)
    {
        return $data = [
            'data' => urlencode(base64_encode(json_encode($data)))
        ];
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->api_key = config('services.klaviyo.api_key');
    }

    /**
     * @return mixed
     */
    public function getApiVersion()
    {
        return $this->api_version = config('services.klaviyo.version');
    }

    /**
     * @return mixed
     */
    public function getBaseArg()
    {
        return $array = ['api_key' => $this->api_key ? $this->api_key : $this->getApikey()];
    }

    /**
     * @return mixed
     */
    public function getBaseParam()
    {
        return $array = ['token' => $this->token ? $this->token : $this->getToken()];
    }

    public function getClient()
    {
        return new Client(['base_uri' => $this->getHost()]);
    }

    /**
     * @return mixed
     */
    public function getCustomProps()
    {
        return $this->custom_props;
    }

    /**
     * @return mixed
     */
    public function getCustomerProperties()
    {
        return $this->customer_properties;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email = config('services.klaviyo.email');
    }

    /**
     * @return mixed
     */
    public function getEndPoint()
    {
        return $this->endpoint ? $this->endpoint : request()->path();
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event ? $this->event : request()->input('event');
    }

    /**
     * @return mixed
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host = config('services.klaviyo.host');
    }

    public function getMethod()
    {
        return request()->method();
    }

    /**
     * @return mixed
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @return mixed
     */
    public function getProps()
    {
        return $this->props;
    }

    /**
     * @return mixed
     */
    public function getRequestOption()
    {
        return $this->request_option ? $this->request_option : 'query';
    }

    /**
     * @return mixed
     */
    public function getSampleContext()
    {
        return $context = [
            '$id'               => 'zYw4uK',
            '$email'            => 'leebinx@gmail.com ',
            '$first_name'       => 'Glenn',
            '$last_name'        => 'Livingstone',
            '$organization'     => 'U.S. Government', // none
            '$title'            => 'Ex-president',    // none
            '$city'             => 'Mount Vernon',    // London
            '$region'           => 'Virginia',        // None
            '$zip'              => '22121',           // SE19SG
            '$country'          => 'United States',   // United Kingdom
            '$timezone'         => 'US/Eastern',      // none
            '$phone_number'     => '123456789',       // none
            'test'              => 'this is a test',
            'favorite_icecream' => 'double dutch'
        ];
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time ? $this->time : request()->input('time');
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token = config('services.klaviyo.token');
    }

    /**
     * @param $method
     * @param $endpoint
     * @param $args
     * @return mixed
     */
    public function makeCall($method = 'GET', $endpoint, $args)
    {
        $client   = $this->getClient();
        $response = $client->request($method, $endpoint, [$this->getRequestOption() => $args]);
        $data     = $response->getBody()->getContents();
        $data     = json_decode($data, true);
        return $data;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function setApiKey($key)
    {
        return $this->api_key = $key;
    }

    /**
     * @param $version
     * @return mixed
     */
    public function setApiVersion($version)
    {
        return $this->api_version = $version;
    }

    /**
     * @param $context
     * @return mixed
     */
    public function setCustomProps($context)
    {
        $except = ['$object', '$id', 'object', 'id'];

        foreach ($context as $key => $value) {
            $withTag = strpos($key, $this->tag);

            if (false === $withTag && !in_array($key, $except, true)) {
                $this->addCustomProps($key, $value);
            }
        }

        return $this->custom_props;
    }

    /**
     * @param $context
     * @return mixed
     */
    public function setCustomerProperties($context)
    {
        foreach ($context as $key => $value) {
            $this->addCustomerProperties($key, $value);
        }

        return $this->customer_properties;
    }

    /**
     * @param $email
     * @return mixed
     */
    public function setEmail($email)
    {
        return $this->email = $email;
    }

    /**
     * @param $url
     * @return mixed
     */
    public function setEndPoint($url)
    {
        return $this->endpoint = $this->getApiVersion().$url;
    }

    /**
     * @param $event
     * @return mixed
     */
    public function setEvent($event)
    {
        return $this->event = $event;
    }

    /**
     * @param $filters
     * @return mixed
     */
    public function setFilters($filters)
    {
        foreach ($filters as $key => $value) {
            $this->addFilters($key, $value);
        }

        return $this->filters;
    }

    /**
     * @param $url
     * @return mixed
     */
    public function setHost($url)
    {
        return $this->host = $url;
    }

    /**
     * @param $context
     * @return mixed
     */
    public function setProperties($context)
    {
        foreach ($context as $key => $value) {
            $this->addProperties($key, $value);
        }

        return $this->properties;
    }

    /**
     * @param $context
     * @return mixed
     */
    public function setProps($context)
    {
        $except = ['$object', '$id', 'object', 'id'];

        foreach ($context as $key => $value) {
            $withTag = strpos($key, $this->tag);

            if (false !== $withTag && !in_array($key, $except, true)) {
                $this->addProps($key, $value);
            }
        }

        return $this->props;
    }

    /**
     * @param $option
     * @return mixed
     */
    public function setRequestOption($option)
    {
        return $this->request_option = $option;
    }

    /**
     * @param $time
     * @return mixed
     */
    public function setTime($time)
    {
        return $this->time = $time;
    }

    /**
     * @param $token
     * @return mixed
     */
    public function setToken($token)
    {
        return $this->token = $token;
    }

    /**
     * @param $args
     */
    public function setTrackOnce($args)
    {
        $track_once = array_set($args, 'properties.__track_once__', true);
        return array_add($args, 'properties', $track_once);
    }
}
