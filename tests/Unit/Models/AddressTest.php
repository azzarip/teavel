<?php

use Azzarip\Teavel\Models\Address;
use Azzarip\Teavel\Models\Contact;

it('has one_line', function () {
    $address = Address::factory()->create([
        'name' => 'Name',
        'line1' => 'Street 1',
        'zip' => '1234',
        'city' => 'City',
    ]);
    expect($address->one_line)->toBe('Name, Street 1, 1234 City');
});

it('has two_lines', function () {
    $address = Address::factory()->create([
        'name' => 'Name',
        'line1' => 'Street 1',
        'zip' => '1234',
        'city' => 'City',
    ]);
    expect($address->two_lines)->toBe('Name<br>Street 1, 1234 City');
});

it('has label', function () {
    $address = Address::factory()->create([
        'name' => 'Name',
        'line1' => 'Street 1',
        'zip' => '1234',
        'city' => 'Test',
    ]);
    expect($address->label)->toBe("Name\nStreet 1\n1234 Test");
});

it('can be an array', function () {
    $address = Address::factory()->create([
        'name' => 'Name',
        'line1' => 'Test 1',
        'zip' => '1234',
        'city' => 'Test',
    ]);
    expect($address->toArray())
        ->toBeArray()
        ->toContain('Name')
        ->toContain('Test 1')
        ->toContain('1234 Test');
});

it('has is_shipping bool', function () {
    $contact = Contact::factory()->create();
    $address = Address::factory()->create([
        'contact_id' => $contact,
    ]);

    expect($address->is_shipping)->toBeFalse();

    $contact->update(['shipping_id' => $address->id]);

    $address->refresh();
    expect($address->is_shipping)->toBeTrue();

});

it('has is_billing bool', function () {
    $contact = Contact::factory()->create();
    $address = Address::factory()->create([
        'contact_id' => $contact,
    ]);

    expect($address->is_billing)->toBeFalse();

    $contact->update(['billing_id' => $address->id]);

    $address->refresh();
    expect($address->is_billing)->toBeTrue();

});
