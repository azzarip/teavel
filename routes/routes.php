<?php

use Azzarip\Teavel\Http\Controllers\ClickController;
use Azzarip\Teavel\Http\Controllers\UnsubscribeController;
use Illuminate\Support\Facades\Route;

Route::view('/tvl/{contactUuid}/email/{emailUuid}/unsubscribe', 'teavel::email.unsubscribe');
Route::post('/tvl/{contactUuid}/email/{emailUuid}/unsubscribe', UnsubscribeController::class);
Route::view('/tvl/unsubscribe/success', 'teavel::email.success');

Route::get('/tvl/{contactUuid}/email/{emailUuid}/{action}', ClickController::class);
