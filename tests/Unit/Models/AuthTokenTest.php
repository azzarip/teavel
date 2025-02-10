<?php

use Azzarip\Teavel\Models\AuthToken;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Carbon;

it('creates from contact', function () {
    $contact = Contact::factory()->create();

    AuthToken::generate($contact);

    $this->assertDatabaseHas('auth_tokens', [
        'contact_id' => $contact->id,
    ]);
});

it('finds contact from token and deletes', function () {
    $contact1 = Contact::factory()->create();

    $token = AuthToken::generate($contact1);

    $contact2 = AuthToken::redeem($token);

    expect($contact2)->toBeInstanceOf(Contact::class);
    expect($contact1->id)->toBe($contact2->id);
    $this->assertDatabaseMissing('auth_tokens', [
        'contact_id' => $contact1->id,
    ]);
});

it('returns null if token does not exist', function () {
    $result = AuthToken::redeem('::random_string::');

    expect($result)->toBeNull();
});

it('finds contact from token', function () {
    $contact1 = Contact::factory()->create();
    $token = AuthToken::generate($contact1);

    $futureDate = Carbon::now()->addDays(7);
    Carbon::setTestNow($futureDate);

    $contact2 = AuthToken::redeem($token);

    expect($contact2)->toBeNull();
    $this->assertDatabaseMissing('auth_tokens', [
        'contact_id' => $contact1->id,
    ]);
});
