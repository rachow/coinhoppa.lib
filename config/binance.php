<?php

return [

    /*
    |---------------------------------------------------------
    | Binance Api URL
    |---------------------------------------------------------
    |
    | Here you will need to specify the Service API URL.
    | You must remember to include a trailing slash '/'
    | to the end.
    |
    */
    'api_url' => env('BINANCE_API_URL', [
        'https://api.binance.com',
        'https://api1.binance.com',
        'https://api2.binance.com',
        'https://api3.binance.com',
        'https://api4.binance.com',
    ]),

    /*
    |---------------------------------------------------------
    | Binance Api Version
    |---------------------------------------------------------
    |
    | You can specify the version otherwise leave empty. Also
    | can be used to include any preceeding uri endpoints.
    |
    */
    'api_version' => env('BINANCE_API_VERSION', 'v1/'),

    /*
    |---------------------------------------------------------
    | Binance Api Token
    |---------------------------------------------------------
    |
    | If there is a bearer token then specify otherwise null
    |
    */
    'api_token' => env('BINANCE_API_TOKEN', null),

    /*
    |---------------------------------------------------------
    | Binance WebSocket URL
    |---------------------------------------------------------
    |
    | Here you will need to specify the Service WebSocket URL.
    | You must remember to include a trailing slash '/'
    | to the end.
    |
    */
    'api_version' => env('BINANCE_WSS_URL', 'wss://fstream.binance.com/ws/'),
  
];

