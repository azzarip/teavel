<?php

use Azzarip\Teavel\Models\Contact;

beforeEach(function () {
    $this->data = [
        'first_name' => '::name::',
        'last_name' => '::last_name::',
        'phone' => '+41787123123',
        'email' => 'test@email.com',
    ];
});
it('creates a new contact', function () {
    Contact::get($this->data);
    $this->assertDatabaseHas('contacts', $this->data);
});

it('returns a contact', function () {
    $contact = Contact::get($this->data);
    expect($contact)->toBeInstanceOf(Contact::class);
});

it('has no marketing_at', function () {
    $contact = Contact::get($this->data);
    expect($contact->marketing_at)->toBeNull();
});

it('can add marketing_at', function () {
    $this->data['marketing'] = true;
    $contact = Contact::get($this->data);
    expect($contact->marketing_at)->not->toBeNull();
});

test('no new contact for existing email', function () {
    $data1 = $this->data;
    $data2 = [
        'first_name' => '::another_name::',
        'last_name' => '::another_last_name::',
        'email' => 'test@email.com',
    ];

    Contact::get($data1);
    Contact::get($data2);
    $this->assertDatabaseHas('contacts', $data1);
    $this->assertDatabaseMissing('contacts', $data2);
});

it('adds attributes if empty', function () {
    $this->data['last_name'] = null;
    $this->data['phone'] = null;
    $this->data['password'] = null;
    $contact = Contact::get($this->data);

    $this->data['last_name'] = '::last_name::';
    $this->data['phone'] = '::phone::';
    $this->data['password'] = '::password::';
    $contact = Contact::get($this->data);
    expect($contact->last_name)->toBe('::last_name::');
    expect($contact->phone)->toBe('::phone::');
    expect($contact->password)->not->toBeNull();
});
