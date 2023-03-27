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

    // 'firebase' => [
    //     'api_key' => 'AIzaSyBcS3jwiaCmOd1QvubJj63mbnAeR4wgXHY',
    //     'auth_domain' => 'dinnertech-customer-a1ad9.firebaseapp.com',
    //     'database_url' => 'https://dinnertech-customer-a1ad9-default-rtdb.firebaseio.com',
    //      //   'secret' => 'nw7gfrCXmuPfVZ4bMSsOCYeEr7ZwB6897CjyugzU',
    //     'storage_bucket' => 'dinnertech-customer-a1ad9.appspot.com',
    //     'project_id' => 'dinnertech-customer-a1ad9',
    //     'messaging_sender_id' => 'G-CQCME6WE0F'
    // ],
    'firebase' => [
        'apiKey'=> 'AIzaSyBcS3jwiaCmOd1QvubJj63mbnAeR4wgXHY',
        'authDomain'=> 'dinnertech-customer-a1ad9.firebaseapp.com',
        'databaseURL'=> 'https://dinnertech-customer-a1ad9-default-rtdb.firebaseio.com',
        'projectId'=> 'dinnertech-customer-a1ad9',
        'storageBucket'=> 'dinnertech-customer-a1ad9.appspot.com',
        'messagingSenderId'=> '877680709',
        'appId'=> '1:877680709:web:76f6017ff40ed6907dab2c',
        'measurementId'=> 'G-CQCME6WE0F'
    ],

    'google' => [
        'client_id' => '877680709-t9rhotg153sn1gae90q7rutpc5r6avcc.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://localhost:8000/customer/auth/google/callback',
    ],
];
