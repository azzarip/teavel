<?php

use Azzarip\Teavel\Http\Controllers\Api\StripeController;
use Illuminate\Support\Facades\Route;

Route::group([
    'domain' => config('domains.api.url'),
    'middleware' => 'api',
], function () {
    Route::post('/stripe', StripeController::class);
});
