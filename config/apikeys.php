<?php

return
    [
        // Google NTB Api key Credentials

        'Google_Key' => 'AIzaSyDIPbhytGCc5Oc6u41jD3n25AeVTfDXezM',

        // Google Netblaze Api key Credentials

        'googleApi' => env('googleApi'),

        'STRIPE_KEY' => env('STRIPE_KEY'),

        'STRIPE_SECRET' => env('STRIPE_SECRET'),

        'TWILIO_SID' => env('TWILIO_SID'),

        'TWILIO_TOKEN' => env('TWILIO_TOKEN'),

        'TWILIO_FROM' => env('TWILIO_FROM'),

        'engineId' => '005484247109571911046:caci1nizay0',
        // Google Analytics  CallBack

//        'CallBack' => 'http://staging.nichepractice.net/google-analytics/callback',  //for dev
        //'CallBack' => 'http://localhost/projects/madison-api/google-analytics/callback',  //for local


        // Buzzsumo Netblaze Api Credentials

        'BUZZSUMO_API_KEY' =>'GQSHc3bJJY2NpbgHKrdPWR0gAEW9E5L4',

//        'FACEBOOK_APP_ID' => '1220141671409114',
//        'FACEBOOK_APP_SECRET' => '0835ce1f23f40e08d741dfbae8481728',

        // niche
//        'FACEBOOK_APP_ID' => '1220141671409114',
//        'FACEBOOK_APP_SECRET' => '0835ce1f23f40e08d741dfbae8481728',

        'FACEBOOK_APP_ID' => '752672228993528',
        'FACEBOOK_APP_SECRET' => '3060e58e9c87e0ebfdb61b33e4668edb',

//        'FACEBOOK_APP_ID' => '1942980529289838',
//        'FACEBOOK_APP_SECRET' => '54c688820f6a4e66c585d4ea32c2bf60',

        //  Facebook Development Netblaze App Credentials
        'Test_FACEBOOK_APP_ID' => '395729387633825',
        'Test_FACEBOOK_APP_SECRET' => '52683a93bba3dbe0d249c78941eb2072',

        // Brightlocal Netblaze Api key Credentials

        'BrightLocal_key' => '752192015e5b34fdd5f330121d17701573548176',
        'BrightLocal_secret' => '5b6d5eabf0174',

        //Amember Api Key

        'AMEMBER_APP_KEY' => '9d9mlfiUm1I57GMlGqIm',


        //Aweber Credentials

        'AWEBER_CONSUMER_KEY' => 'Ak5hQjTMik74ehDwk34StNLD',

        'AWEBER_CONSUMER_SECRET' => 'y9Rwigej89qjGT37wY5xQGvw2lYh6cx2qccKZGP9',


        'AWEBER_ACCESS_TOKEN_KEY' => 'AgJ85WOjcLrGYs8s9h3cZOyv',

        'AWEBER_ACCESS_TOKEN_SECRET' => 'Wqhh4W10k4BJ7SYHrbamzHgr89PYhBSZnVmLUtnH',

//        'fromEmail' => 'support@nichepractice.com',
//        'fromEmail' => 'admin@penandweb.com',
        'fromEmail' => 'admin@nichepractice.com',

        'sendgrid_api_key' => env('sendgrid_key'),

//        'APP_ENV' => 'development', // 'local', 'development', 'UAT', 'production'
        'APP_ENV' => env('APP_ENV'), // 'local', 'development', 'UAT', 'production'

        'backupMode' => 'backup',
//        'CallBack' => 'https://dev-api.netblaze.com/google-analytics/callback',
        'CallBack' => env('GOOGLE_ANALYTICS_CALLBACK_URL'),
//        'CallBack' => 'https://app.nichepractice.com/google-analytics/callback',
    ];
