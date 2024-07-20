<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Azzarip\Teavel\Http\Middleware\HandleUTM;
use function Pest\Laravel\get;

beforeEach(function () {
    Route::middleware(['web', HandleUTM::class])->get('/test', function () {
        return response('Middleware Test');
    });
});

it('stores utm_source in session if present in GET request', function () {
    $this->get('/test?utm_source=source')->assertOk();

    expect(session('utm.source'))->toBe('source');
});

it('does not store utm_source in session if not present in GET request', function () {
    get('/test')->assertStatus(200);

    expect(session('utm.source'))->toBeNull();
});

it('overwrites the utm_source if a new is given', function () {
    get('/test?utm_source=source1')->assertOk();

    get('/test?utm_source=source2')->assertOk();

    expect(session('utm.source'))->toBe('source2');
});

it('stores all utms', function () {
    get('/test?utm_source=source&utm_medium=medium&utm_content=content&utm_campaign=campaign&utm_term=term')->assertOk();

    expect(session('utm.source'))->toBe('source');
    expect(session('utm.medium'))->toBe('medium');
    expect(session('utm.campaign'))->toBe('campaign');
    expect(session('utm.content'))->toBe('content');
    expect(session('utm.term'))->toBe('term');
});

it('stores all utms and missing are empty ', function () {
    get('/test?utm_source=source&utm_medium=medium&utm_campaign=campaign&utm_term=term')->assertOk();

    expect(session('utm.source'))->toBe('source');
    expect(session('utm.medium'))->toBe('medium');
    expect(session('utm.campaign'))->toBe('campaign');
    expect(session('utm.content'))->toBeNull();
    expect(session('utm.term'))->toBe('term');
});

it('stores google click_id for gclid', function () {
    get('/test?utm_source=google&gclid=1234')->assertOk();

    expect(session('utm.source'))->toBe('google');
    expect(session('utm.click_id'))->toBe('1234');
});

it('stores gclid without source as google', function () {
    get('/test?gclid=1234')->assertOk();

    expect(session('utm.source'))->toBe('google');
    expect(session('utm.click_id'))->toBe('1234');
});
