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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'firebase' => [
        'api_key' => env('FIRE_BASE_API_KEY'),
        'auth_domain' => env('FIRE_BASE_AUTH_DOMAIN'),
        'database_url' => env('FIRE_BASE_DATABASE_URL'),
        'project_id' => env('FIRE_BASE_PROJECT_ID'),
        'storage_bucket' => env('FIRE_BASE_STORAGE_BUCKET'),
        'messaging_sender_id' => env('FIRE_BASE_SENDER_ID'),
        'app_id' => env('FIRE_BASE_APP_ID'),
        'measurement_id' => env('FIRE_BASE_MEASUREMENT_ID'),
    ],

//    'facebook' => [
//        'client_id' => '252146136882165',
//        'client_secret' => '1a5c10035c763fa9845f86826f80de47',
//        'redirect' => 'https://v2.iisbd.io/callback/facebook',
//    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),  // Your Facebook App ID
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'), // Your Facebook App Secret
        'redirect' => env('FACEBOOK_CALLBACK_URL'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),  // Your Google App ID
        'client_secret' => env('GOOGLE_CLIENT_SECRET'), // Your Google App Secret
        'redirect' => env('GOOGLE_CALLBACK_URL'),
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'), // Your GitHub Client ID
        'client_secret' => env('GITHUB_CLIENT_SECRET'), // Your GitHub Client Secret
        'redirect' => env('GITHUB_CALLBACK_URL'),
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),  // Your Twitter Client ID
        'client_secret' => env('TWITTER_CLIENT_SECRET'), // Your Twitter Client Secret
        'redirect' => env('TWITTER_CALLBACK_URL'),
    ],


];