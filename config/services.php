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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'api' => [
        'secret_key' => env('API_SECRET_KEY'),
        'seven_key' => env('API_SEVEN_KEY'),
    ],

    'token' => [
        'secret_token' => env('API_SECRET_TOKEN'),
        'seven_token' => env('API_SEVEN_TOKEN'),
    ],

    'payment' => [
        'base_url' => env('BASE_PAYMENT_URL'),
        'merchant_id_credit' => env('MERCHANT_ID_CREDIT'),
        'merchant_id_etc' => env('MERCHANT_ID_ETC'),
        'secret_key' => env('PAYMENT_SECRETKEY'),
        'backend_return' => env('PAYMENT_RESPONSE_BACKEND'),
        'frontend_return' => env('PAYMENT_RESPONSE_FRONTEND')
    ]

];
