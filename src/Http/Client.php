<?php
 
 namespace Blueskyci\PointClickCare\Http;

use Blueskyci\PointClickCare\Http\PccApi;
use Blueskyci\PointClickCare\Http\Response;
use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Support\Facades\Cache;

class Client 
 {
     /** @var string */
     public $token;

    /** @var \Blueskyci\PointClickCare\Http\PccApi */
    public $client;

    /** @var */
    public $baseApiPath = 'https://connect2.pointclickcare.com/api/public/preview1';

    /** @var */
    public $apiAuthPath = 'https://connect.pointclickcare.com/auth';

    /**
     * Guzzle allows options into its request method. Prepare for some defaults.
     *
     * @var array
     */
    protected $clientOptions = [];

    /**
     * if set to false, no Response object is created, but the one from Guzzle is directly returned
     * comes in handy on error handling.
     *
     * @var boolean
     */
    protected $wrapResponse = true;

    /** @var string */
    protected $user_agent = 'Blueskyci_PointClickCare_PHP/1.0.0';

    public function __construct($config = [], $client = null, $clientOptions = [], $wrapResponse = true)
    {
        $this->clientOptions = $clientOptions;
        $this->wrapResponse = $wrapResponse;

        if (!isset($config['orgUuid']))
            throw new Exception('You must provide an organization Uuid');

        $client = new PccApi([
            'clientId' => $config['clientId'],
            'clientSecret' => $config['clientSecret'],
            'urlAuthorize' => $this->apiAuthPath.'/login',
            'urlAccessToken' => $this->apiAuthPath.'/token',
            'urlResourceOwnerDetails' => $this->baseApiPath,
        ]);

        if(!file_exists(config('point-click-care.ssl_cert_path'))) {
            throw new Exception('You must provide an TLS/SSL certificate');
        };

        $client->setHttpClient(new GuzzleHttpClient([
            'curl' => [CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2],
            'ssl_key' => config('point-click-care.ssl_key_path'),
            'cert' => config('point-click-care.ssl_cert_path'),
        ]));

        $this->token = Cache::remember('pcc.auth.token', 300, function () use ($client) {
            return isset($this->token) ? $this->token : $client->getAccessToken('client_credentials');
        });


        $this->client = $client;

    }

    /**
     * Send the request
     *
     * @return void
     */
    public function request($method, $endpoint, array $options = [], $query_string = null, $requires_auth = true)
    {
        $url = $this->baseApiPath.'/orgs/'.config('point-click-care.orgUuid').'/'.$endpoint;

        $response = $this->client->getAuthenticatedRequest(
            $method,
            $url.'?'.$query_string,
            $this->token,
            $options,
        );

        return new Response($this->client->getResponse($response));
    }
 }

