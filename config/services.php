<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
//        'model' => App\User::class,
        'model' => \Modules\User\Models\Users::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID','ihtbOOA7fG1uRjoJVBRWbhHja'),         // Your GitHub Client ID
        'client_secret' => env('TWITTER_CLIENT_SECRET','91kkimB2q7t7zJVBIeDlBt6IfTEPzXDdeNOej1yBKgtsC2rvVe'), // Your GitHub Client Secret

//        'client_id' => env('TWITTER_CLIENT_ID','ss9jlcJI2sWWzF1xGnv1ZNZqI'),         // Your GitHub Client ID
//        'client_secret' => env('TWITTER_CLIENT_SECRET','axbyCv60hyFGVOqZTKF372SKQqhAuCYrGoO7LAMry2rX12RZfW'), // Your GitHub Client Secret
        'redirect' => env('TWITTER_CALLBACK_URL'),
//        'redirect' => getDomain() . 'api/twitter/callback',
//        'redirect' => 'https://app.nichepractice.com/api/twitter/callback',
//        'redirect' => 'http://localhost:81/projects/nichepractice/api/twitter/callback',
//        'redirect' => 'http://localhost/nichepractice/api/twitter/callback',
    ]

];
