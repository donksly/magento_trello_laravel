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
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'trello' => [
        'client_id' => env('TRELLO_KEY', '4ff88df6485dd26e226982183a361880'),
        'client_secret' => env('TRELLO_SECRET', '7c23575bd820e6716e28bf3db142929d48a056caac35f38bb03f21c2664b2752'),
        'redirect' => env('TRELLO_REDIRECT_URI', 'https://stocklyretailer.herokuapp.com/api/trellotoken')
    ],

];
