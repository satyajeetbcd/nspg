<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mail Provider Configurations
    |--------------------------------------------------------------------------
    |
    | Different SMTP configurations for fallback when primary fails
    |
    */

    'providers' => [
        'primary' => [
            'host' => env('MAIL_HOST', 'smtpout.secureserver.net'),
            'port' => env('MAIL_PORT', 587),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'timeout' => 10,
        ],
        
        'gmail' => [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'encryption' => 'tls',
            'timeout' => 15,
        ],
        
        'outlook' => [
            'host' => 'smtp-mail.outlook.com',
            'port' => 587,
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'encryption' => 'tls',
            'timeout' => 15,
        ],
        
        'yahoo' => [
            'host' => 'smtp.mail.yahoo.com',
            'port' => 587,
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'encryption' => 'tls',
            'timeout' => 15,
        ],
    ],
    
    'fallback_order' => ['primary', 'gmail', 'outlook', 'yahoo'],
];
