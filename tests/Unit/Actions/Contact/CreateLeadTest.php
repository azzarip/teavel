<?php

use Azzarip\Teavel\Actions\Contact\CreateLead;
use Azzarip\Teavel\Models\Contact;

it('creates a contact lead with email', function () {
    $email = fake()->safeEmail();

    $contact = CreateLead::create($email);

    expect($contact)->not->toBeNull();
    expect($contact->email)->toBe($email);
    expect($contact)->toBeInstanceOf(Contact::class);
    expect($contact->privacy_at)->not->toBeNull();
    expect($contact->canReceiveEmail())->not->toBeNull();

});

it('returns contact if already exists', function () {
    $contact = Contact::factory()->create();

    $lead = CreateLead::create($contact->email);

    expect($lead->id)->toBe($contact->id);
});
