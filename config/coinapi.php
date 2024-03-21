<?php

return [

    /*
    |---------------------------------------------------------
    | Coincap Api URL
    |---------------------------------------------------------
    |
    | Here you will need to specify the Service API URL.
    | You must remember to include a trailing slash '/'
    | to the end.
    |
    */
    'api_url' => env('COINAPI_API_URL', 'https://rest.coinapi.io/'),

    /*
    |---------------------------------------------------------
    | Coincap Api Version
    |---------------------------------------------------------
    |
    | You can specify the version otherwise leave empty. Also
    | can be used to include any preceeding uri endpoints.
    |
    */
    'api_version' => env('COINAPI_API_VERSION', 'v1/'),

    /*
    |---------------------------------------------------------
    | Coincap Api Token
    |---------------------------------------------------------
    |
    | If there is a bearer token then specify otherwise null
    |
    */
    'api_token' => env('COINAPI_API_TOKEN', null),

    /*
    |---------------------------------------------------------
    | Coincap API X Header Key
    |---------------------------------------------------------
    |
    | We would send an 'X' Header with each request. This allows
    | You to override the default UUID string that is generated.
    |
    */
    'request_key' => env('COINAPI_API_KEY', '!$$$.!#'),
];
