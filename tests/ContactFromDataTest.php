<?php

use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Arr;

beforeEach(function () {
    $this->data = [
        'first_name' => '::name::',
        'last_name' => '::last_name::',
        'phone' => '+41787123123',
        'email' => 'test@email.com',
    ];
});
it('creates a new contact', function () {
    $contact = Contact::fromData($this->data);
    $this->assertDatabaseHas('contacts', $this->data);
});

it('returns a contact', function () {
    $contact = Contact::fromData($this->data);
    expect($contact)->toBeInstanceOf(Contact::class);
});

it('has marketing at = now()', function () {
    $contact = Contact::fromData($this->data);
    expect($contact->marketing_at)->not->toBeNull();
});

test('no new contact for existing email', function () {
    $data1 = $this->data;
    $data2 = [
        'first_name' => '::another_name::',
        'last_name' => '::another_last_name::',
        'email' => 'test@email.com',
    ];

    Contact::fromData($data1);
    Contact::fromData($data2);
    $this->assertDatabaseHas('contacts', $data1);
    $this->assertDatabaseMissing('contacts', $data2);
});

it('adds last_name if empty', function () {
    $this->data['last_name'] = null;
    $contact = Contact::fromData($this->data);
    expect($contact->last_name)->toBeNull();

    $this->data['last_name'] = '::last_name::';
    $contact = Contact::fromData($this->data);
    expect($contact->last_name)->toBe('::last_name::');

});

it('adds phone if empty', function () {
    $this->data['phone'] = null;
    $contact = Contact::fromData($this->data);
    expect($contact->phone)->toBeNull();

    $this->data['phone'] = '+41787878787';
    $contact = Contact::fromData($this->data);
    expect($contact->phone)->toBe('+41787878787');

});

it('DOES NOT add marketing_at if not_marketing', function () {
    $this->data['not_marketing'] = true;
    $contact = Contact::fromData($this->data);
    expect($contact->marketing_at)->toBeNull();

    $contact = Contact::fromData($this->data);
    expect($contact->marketing_at)->toBeNull();
});

it('adds marketing_at if empty ', function () {
    $this->data['not_marketing'] = true;
    $contact = Contact::fromData($this->data);
    expect($contact->marketing_at)->toBeNull();

    Arr::forget($this->data, 'not_marketing');
    $contact = Contact::fromData($this->data);
    expect($contact->marketing_at)->not->toBeNull();

});
