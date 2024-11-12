<?php

use Illuminate\Support\Facades\Route;
use Azzarip\Teavel\Http\Controllers\ClickController;
use Azzarip\Teavel\Http\Controllers\LoginController;
use Azzarip\Teavel\Http\Controllers\LogoutController;
use Azzarip\Teavel\Http\Controllers\AddressController;
use Azzarip\Teavel\Http\Controllers\PasswordController;
use Azzarip\Teavel\Http\Controllers\TokenLoginController;
use Azzarip\Teavel\Http\Controllers\SetPasswordController;
use Azzarip\Teavel\Http\Controllers\UnsubscribeController;

Route::group([
    'middleware' => 'web',
    'domain' => config('teavel.domain')
], function () {

//**   Unsubscribe EMAILS  */
Route::view('/tvl/{contactUuid}/email/{emailUuid}/unsubscribe', 'teavel::email.unsubscribe');
Route::post('/tvl/{contactUuid}/email/{emailUuid}/unsubscribe', UnsubscribeController::class);
Route::view('/tvl/unsubscribe/success', 'teavel::email.success');

//**   Click on Email  */
Route::get('/tvl/{contactUuid}/email/{emailUuid}/{action}', ClickController::class);


//**   AUTH ROUTES  */
Route::middleware(['auth'])->post('/logout', LogoutController::class)->name('logout');
Route::get('/login/{token}', TokenLoginController::class)->name('login.token');

Route::middleware(['guest'])->group(function () {
    Route::view('/login', config('teavel.auth_views.login'))->name('login');

    Route::view('/password/request', config('teavel.auth_views.password_request'))->name('password.request');
    Route::view('/password/success', config('teavel.auth_views.password_success'))->name('password.success');
    Route::view('/password/reset', config('teavel.auth_views.password_reset'))->name('password.reset');

    Route::middleware(['throttle:5'])->group(function () {
        Route::post('/password/request', [PasswordController::class, 'request']);
        Route::post('/password/reset', [PasswordController::class, 'reset']);
        Route::post('/login', LoginController::class);
        Route::post('/password/set', [SetPasswordController::class, 'internal'])->name('password');
    });
});

//** ADDRESS ROUTES */
    Route::middleware(['auth'])->post('/tvl/address', [AddressController::class, 'store'])->name('address.create');
    Route::middleware(['auth'])->put('/tvl/address', [AddressController::class, 'update'])->name('address.edit');

});

Route::post('/auth/password', [SetPasswordController::class, 'external'])->middleware(['web', 'throttle:5'])->name('set.password');