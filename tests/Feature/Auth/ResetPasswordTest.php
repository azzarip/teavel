<?php

use function Pest\Laravel\post;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

beforeEach(function() {
    Mail::fake();
    $this->withoutMiddleware();
    $this->data = [
        'uuid' => '::uuid::',
        'password' => '::password::',
        'token' => '::token::',
    ];
});

it('requires token', function() {
    unset($this->data['token']);
    post(route('password.reset'), $this->data)->assertSessionHasErrors('token');
});

it('requires uuid', function() {
    unset($this->data['uuid']);
    post(route('password.reset'), $this->data)->assertSessionHasErrors('uuid');
});

it('validates password', function() {
    unset($this->data['password']);
    post(route('password.reset'), $this->data)->assertSessionHasErrors('password');

    $this->data['password'] = '1234567';
    post(route('password.reset'), $this->data)->assertSessionHasErrors('password');
});

// it('redirects to request if token expired', function () {
//     post(route('password.reset'), $this->data)
//         ->assertRedirect(route('password.request_form'))
//         ->assertSessionHasErrors('token');
// });

it('changes password', function () {
    $contact = Contact::factory()->create(['email' => 'real@email.com', 'password' => bcrypt('password')]);

    $token = Password::getRepository()->create($contact);

    post(route('password.reset'), [
        'uuid' => $contact->uuid,
        'token' => $token,
        'password' => '::new_password::',
    ])
        ->assertRedirect(route('login'))
        ->assertSessionHas('status');

    $contact->refresh();
    $this->assertTrue(Hash::check('::new_password::', $contact->password));
});
