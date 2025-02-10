<?php

use Azzarip\Teavel\Models\Address;
use Azzarip\Teavel\Models\Contact;

beforeEach(function () {
    $this->contact = Contact::factory()->create();
    $this->actingAs($this->contact);

    $this->data = [
        'id' => 1,
        'name' => '::name::',
        'line1' => '::line1::',
        'city' => '::city::',
        'zip' => '1234',
        'shipping' => true,
        'billing' => true,
    ];

    $this->address = Address::factory()->create(['contact_id' => 1]);
});

it('requires id', function () {
    unset($this->data['id']);
    $this->put(route('address.edit'), $this->data)
        ->assertSessionHasErrors('id');
});

test('id must be int', function () {
    $this->data['id'] = '::wrong_id::';
    $this->put(route('address.edit'), $this->data)
        ->assertSessionHasErrors('id');
});

it('returns 403 if address does not exist', function () {
    $this->data['id'] = 2;
    $this->put(route('address.edit'), $this->data)->assertForbidden();
});

it('returns 403 if address does not match contact', function () {
    $addressNew = Address::factory()->create(['contact_id' => 2]);
    $this->data['id'] = $addressNew->id;
    $this->put(route('address.edit'), $this->data)->assertForbidden();
});

it('deletes address', function () {
    $this->put(route('address.edit'), $this->data);

    $this->address->refresh();
    expect($this->address->trashed())->toBe(true);
});

it('creates a new address', function () {
    $this->put(route('address.edit'), $this->data);

    $this->contact->refresh();
    expect($this->contact->shipping_id)->not->toBe($this->address->id);
    expect($this->contact->shipping_id)->not->toBeNull();
});
