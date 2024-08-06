<?php

use Azzarip\Teavel\Models\Contact;
use Illuminate\Validation\ValidationException;

beforeEach(function () {
    $this->data = [
        'first_name' => '::name::',
        'last_name' => '::last_name::',
        'phone' => '+41787123123',
        'email' => 'test@email.com',
        'password' => 'password',
    ];
});
it('creates a new contact', function () {
    Contact::register($this->data);
    unset($this->data['password']);
    $this->assertDatabaseHas('contacts', $this->data);
});

it('returns a contact', function () {
    $contact = Contact::register($this->data);
    expect($contact)->toBeInstanceOf(Contact::class);
});

it('has no marketing_at', function () {
    $contact = Contact::register($this->data);
    expect($contact->marketing_at)->toBeNull();
});

it('can add marketing_at', function () {
    $this->data['marketing'] = true;
    $contact = Contact::register($this->data);
    expect($contact->marketing_at)->not->toBeNull();
});


it('adds attributes if empty', function () {
    $this->data['last_name'] = null;
    $this->data['phone'] = null;
    $this->data['password'] = null;
    $contact = Contact::fromData($this->data);

    $this->data['last_name'] = '::last_name::';
    $this->data['phone'] = '::phone::';
    $this->data['password'] = '::password::';
    $contact = Contact::register($this->data);
    expect($contact->last_name)->toBe('::last_name::');
    expect($contact->phone)->toBe('::phone::');
    expect($contact->password)->not->toBe('::password::');
    expect($contact->password)->not->toBeNull();

});

it('throws error when contact already registered', function () {
    Contact::register($this->data);
    $this->data['password'] = 'another_password';

    $this->expectException(ValidationException::class);

    Contact::register($this->data);

});
