<?php

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Database\Factories\ContactFactory;

it('has full name', function () {
    $contact = ContactFactory::new()->create([
        'name' => 'Name',
        'surname' => 'Surname',
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

    $foundContact = Contact::findByEmail($email);
    expect($foundContact)->toBe($contact);
);
