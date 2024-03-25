<?php

return [

    /*
    |---------------------------------------------------------
    | Kline Service Api URL
    |---------------------------------------------------------
    |
    | Here you will specify the endpoint which is used to call
    | the service which provides the OHLCV data.
    |
    */
    'api_url' => env('KLINE_API_URL', 'http://127.0.0.1:8089/'),

    /*
    |---------------------------------------------------------
    | Kline Service Api Versioning
    |---------------------------------------------------------
    |
    | Here you can include any preceeding uri along with version
    | too or leave empty.
    |
    */
    'api_version' => env('KLINE_API_VERSION', 'api/'),

    /*
    |---------------------------------------------------------
    | Kline Service Api Token
    |---------------------------------------------------------
    |
    | Here you will specify the Api Token if there is one, else
    | you will leave as null
    |
    */
    'api_token' => env('KLINE_API_TOKEN', null),

    /*
    |---------------------------------------------------------
    | Kline Service App Id
    |---------------------------------------------------------
    |
    | The App Id allows the end service to determine and trace
    | the connecting app.
    |
    */
    'app_id' => env('KLINE_APP_ID', 'b90574b7-0dbc-48b5-92d4-e426557266d6'),
];