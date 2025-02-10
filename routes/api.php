<?php 

use Illuminate\Support\Facades\Route;
use Azzarip\Teavel\Http\Controllers\Api\StripeController;

Route::group([
    'domain' => config('domains.api.url'),
    'middleware' => 'api',
], function () {
    Route::post('/stripe', StripeController::class); 
});