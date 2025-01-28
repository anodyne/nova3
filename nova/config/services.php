<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'anodyne' => [
        'links' => [
            'home' => 'https://anodyne-productions.com',
            'nova' => 'https://anodyne-productions.com/nova',
            'exchange' => 'https://anodyne-productions.com/exchange',
            'discord' => 'https://discord.gg/7WmKUks',
            'install-guide' => 'https://anodyne-productions.com/docs/3.0/installation',
            'migrate-guide' => 'https://anodyne-productions.com/docs/3.0/migrate-from-nova2',
            'update-guide' => 'https://anodyne-productions.com/docs/3.0/update',
        ],
        'api' => [
            'addon-version-check' => 'https://anodyne-productions.com.test/api/addon/{id}/latest-version',
            'latest-version' => 'https://anodyne-productions.com.test/api/nova/latest-version',
            'next-version' => 'https://anodyne-productions.com.test/api/nova/next-version',
            'register' => 'https://anodyne-productions.com.test/api/games',
        ],
        'external' => [
            'changelog' => 'https://anodyne-productions.com.test/api/nova/external-changelog',
            'content' => 'https://anodyne-productions.com.test/api/nova/external-content',
        ],
    ],

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

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'github' => [
        'api' => [
            'version' => '2022-11-28',
            'all-releases' => 'https://api.github.com/repos/{id}/releases',
            'latest-release' => 'https://api.github.com/repos/{id}/releases/latest',
        ],
    ],

];
