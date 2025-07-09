<?php 

use Azzarip\Teavel\Locale\SetCookie;

it('queues the lang cookie with correct properties', function () {
    SetCookie::locale('it');

    $cookie = \Illuminate\Support\Facades\Cookie::getQueuedCookies()[0];

    expect($cookie->getName())->toBe('lang')
        ->and($cookie->getValue())->toBe('it')
        ->and($cookie->getExpiresTime())->toBeGreaterThanOrEqual(time() + 60 * 24 * 365)
        ->and($cookie->isHttpOnly())->toBeFalse();
});