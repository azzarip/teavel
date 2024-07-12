<?php

use Azzarip\Teavel\Database\Factories\ContactFactory;
use Azzarip\Teavel\Models\Contact;

it('has full name', function () {
    $contact = ContactFactory::new()->create([
        'first_name' => 'Name',
        'last_name' => 'Surname',
    ]);
    expect($contact->fullName)->toBe('Name Surname');
});

it('has name_email', function () {
    $contact = ContactFactory::new()->create([
        'first_name' => 'Name',
        'last_name' => 'Surname',
        'email' => 'test@example.com',
    ]);
    expect($contact->nameEmail)->toBe('Name Surname (test@example.com)');
});

it('has uuid', function () {
    $contact = ContactFactory::new()->create();
    expect($contact->uuid)->not->toBeNull();
});

it('finds contacts by Email', function () {
    $contact = ContactFactory::new()->create();
    $email = $contact->email;

    $foundContact = Contact::findEmail($email);
    expect($foundContact->first_name)->toBe($contact->first_name);
    expect($foundContact->last_name)->toBe($contact->last_name);
    expect($foundContact->email)->toBe($contact->email);
});

it('can allow Marketing and does not update', function () {
    $contact = ContactFactory::new()->create();
    expect($contact->marketing_at)->toBe(null);
    $contact->allowMarketing(false);
    expect($contact->marketing_at)->toBe(null);
    $contact->allowMarketing();
    expect($contact->marketing_at)->not->toBe(null);
    $this->travel(1)->seconds();
    $timestamp = $contact->marketing_at;
    $contact->allowMarketing();
    expect($contact->marketing_at)->not->toBe($timestamp);
});

it('returns null if marketing_at is empty', function () {
    $contact = ContactFactory::new()->create();
    expect($contact->marketing_at)->toBe(null);
    $contact->allowMarketing();
    expect($contact->marketing_at)->toBeInstanceOf(\Carbon\Carbon::class);
});

it('has can_market attribute', function () {
    $contact = ContactFactory::new()->create(['marketing_at' => null]);

    expect($contact->can_market)->toBeFalse();

    $contact->allowMarketing();

    expect($contact->can_market)->toBeTrue();

});
it('has is registered attribute', function () {
    $contact = ContactFactory::new()->create(['password' => null]);

    expect($contact->is_registered)->toBeFalse();

    $contact->update(['password' => '::password::']);

    expect($contact->is_registered)->toBeTrue();

});
