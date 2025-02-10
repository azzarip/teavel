<?php

use Azzarip\Teavel\Models\AuthToken;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\Route;

beforeEach(function () {
    Route::get('/test', fn () => null)->name('my');
});

it('logs in', function () {
    $contact = Contact::factory()->create();
    $token = AuthToken::generate($contact);

    $this->get('/login/' . $token)->assertRedirect();

    $this->assertAuthenticatedAs($contact);
});

it('does not log in', function () {
    $this->get('/login/' . '::wrong_token::')->assertRedirect();

    $this->assertGuest();
});
