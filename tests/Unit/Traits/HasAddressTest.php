<?php

use Azzarip\Teavel\Models\Address;
use Azzarip\Teavel\Models\Contact;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

beforeEach(function() {
    $this->contact = Contact::factory()->create();
});
it('has shipping address', function () {
    $address = Address::factory()->create(['contact_id' => $this->contact->id]);
    $this->contact->update(['shipping_id' => $address->id]);
    expect($this->contact->shippingAddress)->toBeInstanceOf(Address::class);
    expect($this->contact->shippingAddress->id)->toBe($address->id);
});

it('has billing address', function () {
    $address = Address::factory()->create(['contact_id' => $this->contact->id]);
    $this->contact->update(['billing_id' => $address->id]);
    expect($this->contact->billingAddress)->toBeInstanceOf(Address::class);
    expect($this->contact->billingAddress->id)->toBe($address->id);
});

test('addresses have soft deletes', function () {
    $address = Address::factory()->create();

    $address->delete();

    expect(Address::query()->withTrashed()->where('id', $address->id)->exists())->toBeTrue();
});

test('removing address deletes both', function () {
    $address = Address::factory()->create(['contact_id' => $this->contact->id]);
    $this->contact->update(['billing_id' => $address->id, 'shipping_id' => $address->id]);

    $this->contact->shippingAddress->remove();
    $this->contact->refresh();

    expect($this->contact->shipping_id)->toBeNull();
    expect($this->contact->billing_id)->toBeNull();

});
test('removing address shifts to the previous', function () {
    $addressOld = Address::factory()->create(['contact_id' => $this->contact->id]);
    $addressNew = Address::factory()->create(['contact_id' => $this->contact->id]);
    $this->contact->update(['billing_id' => $addressNew->id, 'shipping_id' => $addressNew->id]);

    $this->contact->shippingAddress->remove();

    $this->contact->refresh();
    expect($this->contact->billingAddress->id)->toBe($addressOld->id);
    expect($this->contact->shippingAddress->id)->toBe($addressOld->id);
    expect(Address::query()->withTrashed()->where('id', $addressNew->id)->exists())->toBeTrue();
});

it('creates a new address w/o assigning', function () {
    $address = $this->contact->createAddress([
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
        'contact_id' => $this->contact->id,
    ]);

    $this->contact->refresh();
    expect($this->contact->shipping_id)->toBeNull();
    expect($this->contact->billing_id)->toBeNull();

});

it('assignes the new address', function () {
    $address = $this->contact->createAddress([
        'name' => '::name::',
        'line1' => '::line1::',
        'city' => '::city::',
        'zip' => '1234',
    ], ['shipping']);
    $this->contact->refresh();
    expect($this->contact->shipping_id)->not->toBeNull();
    expect($this->contact->billing_id)->toBeNull();
});

test('updateAddress return 403 if id is not of contact', function () {
    $address = Address::factory()->create(['contact_id' => 2]);
    $this->contact->updateAddress($address->id, []);

})->throws(HttpException::class);

test('updateAddress return 404 if id not exists', function () {
    $this->contact->updateAddress(1, []);
})->throws(NotFoundHttpException::class);

test('updateAddress updates address', function () {
    $address = Address::factory()->create(['contact_id' => $this->contact->id]);


    $this->contact->updateAddress($address->id, ['name' => '::NAME::']);

    $address->refresh();
    expect($address->name)->toBe('::NAME::');
});
