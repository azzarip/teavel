<?php

use Azzarip\Teavel\Http\Middleware\IntendedRedirect;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\get;

beforeEach(function () {
    Route::middleware(['web', IntendedRedirect::class])->get('/test', function () {
        return response('Middleware Test');
    });
});


it('puts the url in session if not authenticated', function () {
    get('/test')->assertOk();

    expect(session('url.intended'))->toBe('http://localhost/test');
});


it('does nothing if authenticated', function () {
    $this->actingAs(\Azzarip\Teavel\Models\Contact::factory()->create());
    
    get('/test')->assertOk();

    expect(session('url.intended'))->toBeNull();
});