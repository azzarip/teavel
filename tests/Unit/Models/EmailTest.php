<?php

use Azzarip\Teavel\Models\Email;
use Azzarip\Teavel\Models\Sequence;



it('has sequence', function () {
    $sequence = Sequence::name('test');
    $email = Email::create([
        'automation' => '::test::',
        'sequence_id' => $sequence->id,
    ]);

    $Sequence = $email->sequence;
    expect($Sequence)->not->toBeNull();
    expect($Sequence->id)->toBe($sequence->id);
});

test('name retrieves existing email', function () {
    $email = Email::create(['automation' => '::automation::']);

    $Email = Email::name('::automation::');

    expect($Email)->not->toBeNull();
    expect($Email->id)->toBe($email->id);

});

test('name creates a new email', function () {

    $Email = Email::name('::automation::');

    expect($Email)->not->toBeNull();
    expect($Email->automation)->toBe('::automation::');
    expect($Email->sequence)->toBe(null);

});

test('accepts sequence string', function () {
    $Email = Email::name('::automation::', 'sequence');

    expect($Email)->not->toBeNull();
    expect($Email->automation)->toBe('::automation::');
    expect($Email->sequence->id)->not->toBeNull();

});

it('has UUID', function () {
    $email1 = Email::name('::automation::');
    $email2 = Email::findUuid($email1->uuid);
    expect($email1->id)->toBe($email2->id);
});
