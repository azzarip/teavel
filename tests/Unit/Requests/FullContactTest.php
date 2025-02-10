<?php

use Azzarip\Teavel\Http\Requests\FullContactRequest;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\post;

beforeEach(function () {
    Route::post('/test', function (FullContactRequest $request) {
        $request->validated();

        return response('');
    });

    $this->data = [
        'first_name' => '::first_name::',
        'last_name' => '::last_name::',
        'email' => 'email@example.com',
        'phone' => '+41787131882',
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

it('requires first_name', function () {
    $this->data['first_name'] = null;
    post('/test', $this->data)->assertSessionHasErrors('first_name');
});
it('requires first_name < 255 chars', function () {
    $this->data['first_name'] = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWX';
    post('/test', $this->data)->assertSessionHasErrors('first_name');
});

it('requires last_name', function () {
    $this->data['last_name'] = null;
    post('/test', $this->data)->assertSessionHasErrors('last_name');
});

it('requires phone', function () {
    $this->data['phone'] = null;
    post('/test', $this->data)->assertSessionHasErrors('phone');
});

it('requires valid phone', function () {
    $this->data['phone'] = 'wrong_phone_number';
    post('/test', $this->data)->assertSessionHasErrors('phone');
});

it('requires accepted privacy_policy', function () {
    $this->data['privacy_policy'] = null;
    post('/test', $this->data)->assertSessionHasErrors('privacy_policy');
});
