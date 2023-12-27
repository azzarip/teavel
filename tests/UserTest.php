<?php

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