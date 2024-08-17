<?php

use Azzarip\Teavel\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\post;

beforeEach(function () {
    Route::post('/test', function (LoginRequest $request) {
        return response('');
    });

    $this->data = [
        'email' => 'email@example.com',
        'password' => '::password::',
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

it('requires password', function () {
    $this->data['password'] = null;
    post('/test', $this->data)->assertSessionHasErrors('password');
});

