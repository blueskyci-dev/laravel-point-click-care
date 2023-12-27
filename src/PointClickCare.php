<?php

namespace AtumSystems\PointClickCare;

use AtumSystems\PointClickCare\Http\Client;
use AtumSystems\PointClickCare\Resources\Resource;
use Exception;

class PointClickCare {

    protected $client;

    public function __construct(array $config = [], Client $client = null, array $clientOptions = [], $wrapResponse = true)
    {
        if (is_null($client)) {
            $client = new Client($config, null, $clientOptions, $wrapResponse);
        }

        $this->client = $client;
    }

    /**
     * Create an instance of the service using client credentials
     *
     * @param array $config 
     * @param Client $client an Http client
     * @param array $clientOptions options to be send with each request
     * @param boolean $wrapResponse wrap request response in own Response object
     * 
     * @return self
     */
    public static function create(array $config, Client $client = null, array $clientOptions = [], bool $wrapResponse = true) : self
    {
        return new static($config, $client, $clientOptions, $wrapResponse);
    }

    /**
     * Return an instance of a Resource based on the method called.
     *
     * @param string $name
     * @param mixed $args
     * @return Resource
     */
    public function __call(string $name, $args) : Resource
    {
        $resource = 'AtumSystems\\PointClickCare\\Resources\\'.ucfirst($name);

        return new $resource($this->client, ...$args);
    }

    /**
     * Create an instance of the service by organization
     *
     * @param string $orgUuid
     * @param array $config
     * @return void
     */
    public static function organization(string $orgUuid = null, array $config = [])
    {
        if (config('point-click-care.clientId') === null) {
            throw new Exception('You must provide a Client ID');
        }

        if (config('point-click-care.clientSecret') === null) {
            throw new Exception('You must provide a Client Secret');
        }

        $orgUuid = isset($orgUuid) ? $orgUuid : config('point-click-care.orgUuid');

        if ($orgUuid === null) {
            throw new Exception('You must provide an Organization UUID');
        }

        $config = [
            'clientId' => config('point-click-care.clientId'),
            'clientSecret' => config('point-click-care.clientSecret'),
            'orgUuid' => $orgUuid
        ];

        return new static($config);
    }
    
}