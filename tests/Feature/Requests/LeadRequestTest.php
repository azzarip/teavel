<?php

use function Pest\Laravel\post;
use Illuminate\Support\Facades\Route;
use Azzarip\Teavel\Http\Requests\LeadRequest;

beforeEach(function () {
    Route::post('/test', function (LeadRequest $request) {
        return response('');
    });

    $this->data = [
        'first_name' => '::first_name::',
        'email' => 'email@example.com',
        'privacy_policy' => true,
    ];
});

it('passes validation', function () {
    post('/test',$this->data)->assertOk();
});

it('requires email', function () {
    $this->data['email'] = null;
    post('/test',$this->data)->assertSessionHasErrors('email');
});

it('requires valid email', function () {
    $this->data['email'] = '::wrong_email::';
    post('/test',$this->data)->assertSessionHasErrors('email');
});

it('requires first_name', function () {
    $this->data['first_name'] = null;
    post('/test',$this->data)->assertSessionHasErrors('first_name');
});
it('requires first_name < 255 chars', function () {
    $this->data['first_name'] = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWX';
    post('/test',$this->data)->assertSessionHasErrors('first_name');
});

it('requires accepted privacy_policy', function () {
    $this->data['privacy_policy'] = null;
    post('/test',$this->data)->assertSessionHasErrors('privacy_policy');
});

