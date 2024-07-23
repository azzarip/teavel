<?php

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Sequence;
use Azzarip\Teavel\Exceptions\BadMethodCallException;
use Azzarip\Teavel\Exceptions\MissingClassException;

it('returns sequence by name', function () {
    $sequence1 = Sequence::create(['name' => 'test']);
    $sequence2 = Sequence::name('test');

    expect($sequence1->id)->toBe($sequence2->id);
});

it('creates a new sequence if does not exist', function () {
    Sequence::name('test');

    expect(Sequence::count())->toBe(1);
});

it('throws error on missing class', function () {
    $contact = Contact::factory()->create();
    $sequence = Sequence::name('test');

    $sequence->start($contact);

})->throws(MissingClassException::class);

