<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'stripe' => [
        'model' => App\Models\User\User::class,
        'key' => env('STRIPE_PUBLISHABLE_KEY'),
        'secret' => env('STRIPE_SECRET_KEY'),
        'client_id' => env('STRIPE_CLIENT_ID')
    ],

    'pdga' => [
        'username' => env('PDGA_USERNAME'),
        'secret' => env('PDGA_SECRET'),
        'from' => env('TOURNAMENT_DATA_SOURCE_FROM_DATE'),
        'to' => env('TOURNAMENT_DATA_SOURCE_TO_DATE')
    ],

    'foursquare' => [
        'clientId' => env('FOURSQUARE_CLIENT_ID'),
        'clientSecret' => env('FOURSQUARE_SECRET')
    ],

    'darksky' => [
        'secret' => env('DARKSKY_SECRET')
    ],

    'algolia' => [
        'appId' => env('ALGOLIA_APP_ID'),
        'searchKey' => env('ALGOLIA_SEARCH_KEY'),
        'secret' => env('ALGOLIA_SECRET')
    ],

    'mapbox' => [
        'token' => env('MAPBOX_TOKEN')
    ],
];
