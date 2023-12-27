<?php

return [
    'clientId' => env('POINTCLICKCARE_CLIENT_ID'),   
    'clientSecret' => env('POINTCLICKCARE_CLIENT_SECRET'),   
    'orgUuid' => env('POINTCLICKCARE_DEFAULT_ORG_UUID'),   

    'ssl_key_path' => env('POINTCLICKCARE_SSL_KEY_PATH', storage_path('server.key')),
    'ssl_cert_path' => env('POINTCLICKCARE_SSL_CERT_PATH', storage_path('certificate.crt')),
];