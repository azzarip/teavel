<?php

use Azzarip\Teavel\Models\Address;

it('has one_line', function () {
    $address = Address::factory()->create([
        'address' => 'Test 1',
        'plz' => '1234',
        'city' => 'Test',
    ]);
    expect($address->one_line)->toBe('Test 1, 1234 Test');
});

it('has label', function () {
    $address = Address::factory()->create([
        'name' => 'name',
        'address' => 'Test 1',
        'plz' => '1234',
        'city' => 'Test',
    ]);
    expect($address->label)->toBe("name\nTest 1\n1234 Test");
});

it('can be an array', function () {
    $address = Address::factory()->create([
        'name' => 'name',
        'address' => 'Test 1',
        'plz' => '1234',
        'city' => 'Test',
    ]);
    expect($address->toArray())
        ->toBeArray()
        ->toContain('name')
        ->toContain('Test 1')
        ->toContain('1234 Test');

});
