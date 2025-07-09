<?php

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Route;

beforeEach(function () {
    Route::middleware(['web', 'locale'])->get('/test', function () {
        return response()->json([
            'locale' => App::getLocale(),
            ]);
    });
});

it('does not change locale', function () {
    $response = $this->get('/test');

    $response->assertOk();
    $response->assertJson(['locale' => config('app.locale')]);
});

it('sets locale from cookie', function () {
    $response = $this->withUnencryptedCookie('lang', 'it')->get('/test');

    $response->assertOk();
    $response->assertJson(['locale' => 'it']);
});

it('removes lang cookie if not supported', function () {
    $response = $this->withUnencryptedCookie('lang', 'xx')->get('/test');

    $response->assertOk();
    $response->assertJson(['locale' => config('app.locale')]);

    $response->assertCookieExpired('lang');
});

it('forces locale', function () {
    Route::middleware(['web', 'locale:it'])->get('/test/it', function () {
        return response()->json([
            'locale' => App::getLocale(),
            ]);
    });

    $response = $this->withUnencryptedCookie('lang', 'xx')->get('/test/it');
    $response->assertOk();
    $response->assertJson(['locale' => 'it']);
    $response->assertPlainCookie('lang', 'it');

});

it('throws error for unsupported forced locale', function () {
    Route::middleware(['web', 'locale:xx'])->get('/test/xx', function () {
        return response()->json(['locale' => App::getLocale()]);
    });

    $this->withoutExceptionHandling();

    $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
    $this->expectExceptionMessage("Locale 'xx' is not supported.");

    $this->get('/test/xx');
});