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

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'stripe' => [
        'key' => env('pk_test_51QWavTKX75wThlZA4ff4gIOT4IMlo7PminJsNKpSNLbKU2IbpTxXbdgVBneLsbfvVd90bhWbMBPWOo7dkf6UAemD00DLT6Paa0'),
        'secret' => env('sk_test_51QWavTKX75wThlZAbehHp9mqXdi7J3QUDuKeP9iWB6DB1wsOizEmlp6whcFSwACVE1goxqKoJZtTo5YNgKaN7vr300ahIlSvlP'),
    ],

];
