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
