<?php

use Illuminate\Support\Facades\Route;
use Azzarip\Teavel\Http\Controllers\ClickController;
use Azzarip\Teavel\Http\Controllers\PasswordController;
use Azzarip\Teavel\Http\Controllers\UnsubscribeController;
Route::middleware('web')->group(function () {

//**   Unsubscribe EMAILS  */
Route::view('/tvl/{contactUuid}/email/{emailUuid}/unsubscribe', 'teavel::email.unsubscribe');
Route::post('/tvl/{contactUuid}/email/{emailUuid}/unsubscribe', UnsubscribeController::class);
Route::view('/tvl/unsubscribe/success', 'teavel::email.success');

//**   Click on Email  */
Route::get('/tvl/{contactUuid}/email/{emailUuid}/{action}', ClickController::class);


//**   AUTH ROUTES  */
Route::middleware(['guest'])->group(function () {
    Route::view('/login', config('teavel.auth_views.login'))->name('login');
    Route::view('/register', config('teavel.auth_views.register'))->name('register');
    Route::view('/password/request', config('teavel.auth_views.password_request_form'))->name('password.request_form');
    Route::view('/password/success', config('teavel.auth_views.password_request_success'))->name('password.success');
    Route::view('/password/reset', config('teavel.auth_views.password_reset_form'))->name('password.reset_form');

    Route::middleware(['throttle:5'])->group(function () {
        Route::post('/password/request', [PasswordController::class, 'request'])->name('password.request');
        Route::post('/password/reset', [PasswordController::class, 'reset'])->name('password.reset');
    });
});
});
