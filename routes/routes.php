<?php

use Azzarip\Teavel\Http\Controllers\ClickController;
use Azzarip\Teavel\Http\Controllers\UnsubscribeController;
use Illuminate\Support\Facades\Route;

Route::view('/emails/{contactUuid}/unsubscribe/{emailUuid}', 'teavel::email.unsubscribe');
Route::post('/emails/{contactUuid}/unsubscribe/{emailUuid}', UnsubscribeController::class);
Route::view('/emails/unsubscribe/success', 'teavel::email.success');

Route::get('/emails/{emailUuid}/clrd/{contactUuid}/{num}', ClickController::class);
