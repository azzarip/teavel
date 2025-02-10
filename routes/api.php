<?php 

use Illuminate\Support\Facades\Route;
use Domains\Api\Http\Controllers\StripeController;

Route::group([
    'domain' => config('domains.api.url'),
    'middleware' => 'api',
], function () {
    Route::post('/stripe', StripeController::class); 
});