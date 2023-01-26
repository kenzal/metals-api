<?php

// config for Kenzal/MetalsApi
return [
    'access_key' => env('METALS_API_ACCESS_KEY'),
    'host' => env('METALS_API_HOST', 'https://metals-api.com'),
    'port' => env('METALS_API_PORT', null),
    'base' => env('METALS_API_BASE', 'USD'),
    'symbols' => env('METALS_API_SYMBOLS', null),
];
