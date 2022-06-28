<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Icons Sets
    |--------------------------------------------------------------------------
    |
    | With this config option you can define a couple of default icon sets.
    | Provide a key name for your icon set and a combination from the options
    | below.
    |
    */

    'sets' => [
        'fluent' => [
            'path' => 'nova/resources/svg/fluent',
            'prefix' => 'fluent',
            'class' => '',
        ],
        'untitled' => [
            'path' => 'nova/resources/svg/untitled-ui-icons',
            'prefix' => 'untitled',
            'class' => '',
        ],
        'fas' => [
            'path' => 'nova/resources/svg/font-awesome',
            'prefix' => 'fas',
            'class' => '',
        ],
        'empty' => [
            'path' => 'nova/resources/svg/empty-states',
            'prefix' => 'empty',
            'class' => '',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Class
    |--------------------------------------------------------------------------
    |
    | This config option allows you to define some classes which will be
    | applied to all icons by default.
    |
    */

    'class' => 'icon',
];
