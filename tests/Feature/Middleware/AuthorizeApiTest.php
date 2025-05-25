<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Azzarip\Teavel\Http\Middleware\AuthorizeApi;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\get;

beforeEach(function () {
    // Define a test route using the middleware
    Route::middleware([AuthorizeApi::class])
        ->get('/test-auth', fn () => response()->json(['message' => 'Authorized']));
});

it('allows request with correct credentials', function () {
    Config::set('services.azzari-api.server_name', 'testuser');
    Config::set('services.azzari-api.response_password', 'secret');

    $response = get('/test-auth', [
        'PHP_AUTH_USER' => 'testuser',
        'PHP_AUTH_PW' => 'secret',
    ]);

    $response->assertOk();
    $response->assertJson(['message' => 'Authorized']);
});
it('blocks request with wrong credentials', function () {
    Config::set('services.azzari-api.server_name', 'testuser');
    Config::set('services.azzari-api.response_password', 'secret');

    $response = get('/test-auth', [
        'PHP_AUTH_USER' => 'wronguser',
        'PHP_AUTH_PW' => 'wrongpass',
    ]);

    $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    $response->assertJson(['error' => 'Authentication Error.']);
});

it('blocks request with missing credentials', function () {
    Config::set('services.azzari-api.server_name', 'testuser');
    Config::set('services.azzari-api.response_password', 'secret');

    $response = get('/test-auth');

    $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    $response->assertJson(['error' => 'Authentication Error.']);
});