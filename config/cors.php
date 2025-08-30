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
        'http://localhost:5173',

    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
