<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Azzarip\Teavel\Locale\LocaleRouterController;
use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;

beforeEach(function () {
    Config::set('teavel.supported_locales', ['en', 'it']);

    Route::middleware('web')->get('/test', LocaleRouterController::class);
});

it('redirects to lang from cookie if valid', function () {
    $response = $this->withUnencryptedCookie('lang', 'it')->get('/test');

    $response->assertRedirect('/it/test');
});

it('forgets invalid lang cookie and sets locale from Accept-Language', function () {
    $response = $this
        ->withHeader('Accept-Language', 'it;q=1.0,en;q=0.8')
        ->withUnencryptedCookie('lang', 'fr')
        ->get('/test');

    $response->assertRedirect('/it/test');
    $response->assertPlainCookie('lang', 'it');
});


it('falls back to app locale if none supported in Accept-Language', function () {
    app()->setLocale('en');

    $response = $this
        ->withHeader('Accept-Language', 'es-ES, fr-FR')
        ->get('/test');

    $response->assertRedirect('/en/test');

    $cookie = collect($response->headers->getCookies())
        ->firstWhere(fn ($cookie) => $cookie->getName() === 'lang');

    expect($cookie)->not->toBeNull();
    expect($cookie->getValue())->toBe('en');
});

it('throws 400 if no supported locales configured', function () {
    Config::set('teavel.supported_locales', []);

    $this->withoutExceptionHandling();

    $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
    $this->expectExceptionMessage('No supported locales set. Check teavel config.');

    $this->get('/test');
});
