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
        'api_key' => 'AIzaSyBcS3jwiaCmOd1QvubJj63mbnAeR4wgXHY',
        'auth_domain' => 'dinnertech-customer-a1ad9.firebaseapp.com',
        'database_url' => 'https://dinnertech-customer-a1ad9-default-rtdb.firebaseio.com',
         //   'secret' => 'nw7gfrCXmuPfVZ4bMSsOCYeEr7ZwB6897CjyugzU',
        'storage_bucket' => 'dinnertech-customer-a1ad9.appspot.com',
        'project_id' => 'dinnertech-customer-a1ad9',
        'messaging_sender_id' => 'G-CQCME6WE0F'
    ]
];
