<?php

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
        'feather' => [
            'path' => 'nova/resources/svg/feather',
            'prefix' => 'feather',
            'class' => 'stroke-current',
        ],
        'fluent' => [
            'path' => 'nova/resources/svg/fluent',
            'prefix' => 'fluent',
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
