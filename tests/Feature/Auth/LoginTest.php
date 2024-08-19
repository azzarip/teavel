<?php

use function Pest\Laravel\post;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

beforeEach(function() {
    Mail::fake();
    $this->withoutMiddleware();
    $this->data = [
        'email' => 'email@example.com',
        'password' => '::password::',
    ];
});

it('requires email', function() {
    unset($this->data['email']);
    post(route('login'), $this->data)->assertSessionHasErrors('email');

    $this->data['email'] = '::wrong_email::';
    post(route('login'), $this->data)->assertSessionHasErrors('email');
});

it('validates password', function() {
    unset($this->data['password']);
    post(route('login'), $this->data)->assertSessionHasErrors('password');

    $this->data['password'] = '1234567';
    post(route('login'), $this->data)->assertSessionHasErrors('password');
});

it('redirects to register if contact does not exist', function() {
    post(route('login'), $this->data)
        ->assertRedirect(route('register'))
        ->assertSessionHasErrors('user')
        ->assertSessionHasInput('email');
});

it('redirects to register if contact is not registered', function() {
    $contact = Contact::factory()->create();
    $this->data['email'] = $contact->email;

    post(route('login'), $this->data)
        ->assertRedirect(route('register'))
        ->assertSessionHasErrors('user')
        ->assertSessionHasInput('email');
});

it('goes back for wrong password', function() {
    $contact = Contact::factory()->create(['password' => bcrypt('::new_password::')]);
    $this->data['email'] = $contact->email;

    post(route('login'), $this->data)
->assertSessionHasErrors('user')
        ->assertSessionHasInput('email');
});

it('logs in', function() {
    $contact = Contact::factory()->create(['password' => bcrypt('::password::')]);

    post(route('login'), [
        'email' => $contact->email,
        'password' => '::password::',
    ])->assertRedirect('/');

    $this->assertAuthenticatedAs($contact);
});

it('redirects to url.intended', function() {
    $contact = Contact::factory()->create(['password' => bcrypt('::password::')]);

    $this->withSession(['url.intended' => '/test'])->post(route('login'), [
        'email' => $contact->email,
        'password' => '::password::',
    ])->assertRedirect('/test');
});
