<?php

return [

    /**
     *  Domain for all the teavel internal routes
     */
    'domain' => '',

    
    'locale' => 'switzerland',

    /**
     * Domain Key of the domain for offers
     */
    'offer_domain_key' => '',

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

    // Teavel Panel Provider
    'panel' => [
        'domain' => '',
        'guard' => 'admin',
    ],
];
