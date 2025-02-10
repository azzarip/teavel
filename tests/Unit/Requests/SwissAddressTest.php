<?php

use Azzarip\Teavel\Http\Requests\SwissAddressRequest;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\post;

beforeEach(function () {
    Route::post('/test', function (SwissAddressRequest $request) {
        return response('');
    });

    $this->data = [
        'name' => '::name::',
        'co' => '::co::',
        'line1' => '::line1::',
        'line2' => '::line2::',
        'city' => '::city::',
        'zip' => '1234',
    ];
});

it('passes validation', function () {
    post('/test', $this->data)->assertOk();
});

it('requires name', function () {
    $this->data['name'] = null;
    post('/test', $this->data)->assertSessionHasErrors('name');
});

it('requires line1', function () {
    $this->data['line1'] = null;
    post('/test', $this->data)->assertSessionHasErrors('line1');
});

it('requires city', function () {
    $this->data['city'] = null;
    post('/test', $this->data)->assertSessionHasErrors('city');
});

it('requires zip', function () {
    $this->data['zip'] = null;
    post('/test', $this->data)->assertSessionHasErrors('zip');
});
it('requires 4 digit zip', function () {
    $this->data['zip'] = '::wrong::';
    post('/test', $this->data)->assertSessionHasErrors('zip');
});

it('does not require co', function () {
    $this->data['co'] = null;
    post('/test', $this->data)->assertSessionDoesntHaveErrors('co');
});

it('does not require line2', function () {
    $this->data['line2'] = null;
    post('/test', $this->data)->assertSessionDoesntHaveErrors('line2');
});

it('does not require info', function () {
    $this->data['info'] = null;
    post('/test', $this->data)->assertSessionDoesntHaveErrors('info');
});
