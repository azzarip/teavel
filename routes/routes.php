<?php

use Illuminate\Support\Facades\Route;
use Azzarip\Teavel\Locale\SetLocaleController;
use Azzarip\Teavel\Http\Controllers\ClickController;
use Azzarip\Teavel\Http\Controllers\LoginController;
use Azzarip\Teavel\Http\Controllers\LogoutController;
use Azzarip\Teavel\Http\Controllers\AddressController;
use Azzarip\Teavel\Http\Controllers\TokenLoginController;
use Azzarip\Teavel\Http\Controllers\SetPasswordController;
use Azzarip\Teavel\Http\Controllers\UnsubscribeController;
use Azzarip\Teavel\Http\Controllers\ResetPasswordController;

Route::group([
    'middleware' => 'web',
    'domain' => config('teavel.domain'),
], function () {

    // **   Unsubscribe EMAILS  */
    Route::view('/tvl/{contactUuid}/email/{emailUuid}/unsubscribe', 'teavel::email.unsubscribe');
    Route::post('/tvl/{contactUuid}/email/{emailUuid}/unsubscribe', UnsubscribeController::class);
    Route::view('/tvl/unsubscribe/success', 'teavel::email.success');

    // **   Click on Email  */
    Route::get('/tvl/{contactUuid}/email/{emailUuid}/{action}', ClickController::class);

    // **   AUTH ROUTES  */
    Route::get('/login/{token}', TokenLoginController::class)->name('login.token');

    Route::middleware(['guest'])->group(function () {
        Route::view('/login', config('teavel.auth_views.login'))->name('login');
        Route::post('/auth/password', [SetPasswordController::class, 'external'])->middleware(['web', 'throttle:5'])->name('set.password');

        Route::view('/password/request', config('teavel.auth_views.password_request'))->name('password.request');
        Route::view('/password/success', config('teavel.auth_views.password_success'))->name('password.success');
        Route::view('/password/reset', config('teavel.auth_views.password_reset'))->name('password.reset');

        Route::middleware(['throttle:5'])->group(function () {
            Route::post('/password/request', [ResetPasswordController::class, 'request']);
            Route::post('/password/reset', [ResetPasswordController::class, 'reset']);
            Route::post('/login', LoginController::class);
            Route::post('/password/set', [SetPasswordController::class, 'internal'])->name('password');
        });
    });

    Route::middleware(['auth'])->group(function () {
        Route::put('/tvl/address', [AddressController::class, 'update'])->name('address.edit');
        Route::post('/password/change', [ResetPasswordController::class, 'change'])->name('password.change');
        Route::post('/logout', LogoutController::class)->name('logout');
    });

});

Route::middleware(['web'])->post('/tvl/address', [AddressController::class, 'store'])->name('address.create');

require_once __DIR__ . '/api.php';

Route::middleware(['web'])->get('telegram-test', function () {
    App\Models\User::first()->notify(new \Azzarip\Teavel\Notifications\TelegramNotification('Test'));
    return 'Message Queued, if not working check the queue.';
});


Route::middleware(['web'])->get('set-locale/{locale}', SetLocaleController::class)
    ->where('locale', '[a-z]{2}')
    ->name('set-locale');