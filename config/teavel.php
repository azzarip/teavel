<?php

return [

/**
 *  Domain for all the teavel internal routes
 */
    'domain' => '',

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

    'post_register' => '',


//Teavel Panel Provider
    'panel' => [
        'domain' => '',
        'guard' => 'admin',
    ]
];
