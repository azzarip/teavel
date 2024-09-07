<?php

use Azzarip\Teavel\Models\Contact;
use function Pest\Laravel\post;

beforeEach(function() {
    $this->contact = Contact::factory()->create();
    $this->actingAs($this->contact);

    $this->data = [
        'name' => '::name::',
        'line1' => '::line1::',
        'city' => '::city::',
        'zip' => '1234',
        'shipping' => true,
        'billing' => true,
    ];
});

it('creates a new address', function() {
    post(route('address.create'), $this->data);

    $this->assertDatabaseHas('addresses', [
        'name' => '::name::',
        'line1' => '::line1::',
        'city' => '::city::',
        'zip' => '1234',
        'contact_id' => $this->contact->id,
    ]);
});

it('sets the address as default', function () {
    post(route('address.create'), $this->data);

    $this->contact->refresh();
    expect($this->contact->shipping_id)->not->toBeNull();
    expect($this->contact->billing_id)->not->toBeNull();
});

it('redirects back', function () {

    $previousUrl = 'http://example.com/previous-page';
    $this->withHeader('Referer', $previousUrl)
        ->post(route('address.create'), $this->data)
        ->assertRedirect($previousUrl);
});
