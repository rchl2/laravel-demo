<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Versioning
    |--------------------------------------------------------------------------
    |
    | Orbit Versioning
    */

    'version' => [
        'number' => 'v0.0.2',
    ],

    /*
    |--------------------------------------------------------------------------
    | Standard configuration
    |--------------------------------------------------------------------------
    |
    | This values is base configuration of framework.
    */

    'seo' => [
        'title'       => 'Local - Project', // Title of page,
        'short_title' => 'Local', // Short title (example using in ACP)
    ],

    /*
    |--------------------------------------------------------------------------
    | Website (routes) links configuration
    |--------------------------------------------------------------------------
    |
    | These values can be set to provide links to the social media.
    */

    'routes' => [
        'facebook'      => '',
        'forum'         => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Auth login configuration
    |--------------------------------------------------------------------------
    |
    | If u wanna use additional column (like 'pin') to sign in set this value to 'true'.
    | Next go to app/Http/Controllers/Auth/RegisterController and uncomment validation rules.
    */

    'auth' => [
        'with_pin' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode whitelist
    |--------------------------------------------------------------------------
    |
    | Place IP addresses that will have a access to the website when site gonna be in maintenance mode.
    | Split addresses with ','.
    */

    'whitelist' => [],
];
