<?php

use Azzarip\Teavel\Http\Requests\EmailRequest;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\post;

beforeEach(function () {
    Route::post('/test', function (EmailRequest $request) {
        return response('');
    });

    $this->data = [
        'email' => 'email@example.com',
        'privacy_policy' => true,
    ];
});

it('passes validation', function () {
    post('/test', $this->data)->assertOk();
});

it('requires email', function () {
    $this->data['email'] = null;
    post('/test', $this->data)->assertSessionHasErrors('email');
});

it('requires valid email', function () {
    $this->data['email'] = '::wrong_email::';
    post('/test', $this->data)->assertSessionHasErrors('email');
});

it('requires accepted privacy_policy', function () {
    $this->data['privacy_policy'] = null;
    post('/test', $this->data)->assertSessionHasErrors('privacy_policy');
});
