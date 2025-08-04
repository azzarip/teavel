<?php

return [

   
    'locale' => 'switzerland',

    'supported_locales' => [
        'en',
        'it',
        'fr',
        'de',
    ],

    /**
     * Auth Views
     * The views that will be loaded to handle authentication and password reset logic.
     */
    'auth_views' => [
        'login' => '',
        'password_request' => '',
        'password_success' => '',
        'password_reset' => '',
    ],

    // Teavel Panel Provider
    'panel' => [
        'domain' => '',
        'guard' => 'admin',
    ],
];
