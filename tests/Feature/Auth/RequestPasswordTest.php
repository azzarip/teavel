<?php

use Azzarip\Teavel\Mail\Mailables\PasswordResetMail;
use function Pest\Laravel\post;
use Azzarip\Teavel\Models\Contact;

use Illuminate\Support\Facades\Mail;
use Azzarip\Teavel\Mail\Mailables\PasswordRegisterMail;

beforeEach(function() {
    Mail::fake();
    $this->withoutMiddleware();
});

it('validates email', function() {
    post(route('password.request'), [])->assertSessionHasErrors('email');
    post(route('password.request'), ['email' => 'wrong_email'])->assertSessionHasErrors('email');
});

it('sends no email if contact does not exists', function () {
    post(route('password.request'), ['email' => 'another@email.com'])->assertRedirect(route('password.success'));

    Mail::assertNothingSent();
});

it('sends registration email if not registered', function () {
    Contact::factory()->create(['email' => 'example@email.com']);

    post(route('password.request'), ['email' => 'example@email.com'])->assertRedirect(route('password.success'));

    Mail::assertSent(PasswordRegisterMail::class);
});

it('sends reset email if registered', function () {
    Contact::factory()->create(['email' => 'real@email.com', 'password' => bcrypt('password')]);

    post(route('password.request'), ['email' => 'real@email.com'])->assertRedirect(route('password.success'));

    Mail::assertSent(PasswordResetMail::class);
});

