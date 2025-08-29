<?php

return [

    'paths' => [
        'api/*',
        'login',
        'logout',
        'usuarios/*'
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://gerenciado-app.netlify.app',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
