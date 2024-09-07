<?php

use Azzarip\Teavel\Database\Factories\ContactFactory;
use Azzarip\Teavel\Models\Address;

it('has shipping address', function () {
    $contact = ContactFactory::new()->create();
    $address = Address::factory()->create(['contact_id' => $contact->id]);
    $contact->update(['shipping_id' => $address->id]);
    expect($contact->shippingAddress)->toBeInstanceOf(Address::class);
    expect($contact->shippingAddress->id)->toBe($address->id);
});

it('has billing address', function () {
    $contact = ContactFactory::new()->create();
    $address = Address::factory()->create(['contact_id' => $contact->id]);
    $contact->update(['billing_id' => $address->id]);
    expect($contact->billingAddress)->toBeInstanceOf(Address::class);
    expect($contact->billingAddress->id)->toBe($address->id);
});

test('addresses have soft deletes', function () {
    $address = Address::factory()->create();

    $address->delete();

    expect(Address::query()->withTrashed()->where('id', $address->id)->exists())->toBeTrue();
});

test('removing address deletes both', function () {
    $contact = ContactFactory::new()->create();
    $address = Address::factory()->create(['contact_id' => $contact->id]);
    $contact->update(['billing_id' => $address->id, 'shipping_id' => $address->id]);

    $contact->shippingAddress->remove();
    $contact->refresh();

    expect($contact->shipping_id)->toBeNull();
    expect($contact->billing_id)->toBeNull();

});
test('removing address shifts to the previous', function () {
    $contact = ContactFactory::new()->create();
    $addressOld = Address::factory()->create(['contact_id' => $contact->id]);
    $addressNew = Address::factory()->create(['contact_id' => $contact->id]);
    $contact->update(['billing_id' => $addressNew->id, 'shipping_id' => $addressNew->id]);

    $contact->shippingAddress->remove();

    $contact->refresh();
    expect($contact->billingAddress->id)->toBe($addressOld->id);
    expect($contact->shippingAddress->id)->toBe($addressOld->id);
    expect(Address::query()->withTrashed()->where('id', $addressNew->id)->exists())->toBeTrue();
});

it('creates a new address w/o assigning', function () {
    $contact = ContactFactory::new()->create();
    $address = $contact->createAddress([
        'name' => '::name::',
        'line1' => '::line1::',
        'city' => '::city::',
        'zip' => '1234',
    ]);

    $this->assertDatabaseHas('addresses', [
        'name' => '::name::',
        'line1' => '::line1::',
        'city' => '::city::',
        'zip' => '1234',
        'contact_id' => $contact->id,
    ]);

    $contact->refresh();
    expect($contact->shipping_id)->toBeNull();
    expect($contact->billing_id)->toBeNull();

});

it('assignes the new address', function () {
    $contact = ContactFactory::new()->create();
    $address = $contact->createAddress([
        'name' => '::name::',
        'line1' => '::line1::',
        'city' => '::city::',
        'zip' => '1234',
    ], ['shipping']);
    $contact->refresh();
    expect($contact->shipping_id)->not->toBeNull();
    expect($contact->billing_id)->toBeNull();
});
