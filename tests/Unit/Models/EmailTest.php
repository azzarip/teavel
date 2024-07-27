<?php

use Azzarip\Teavel\Models\Email;
use Azzarip\Teavel\Models\Sequence;
use Azzarip\Teavel\Models\EmailFile;


it('has emailfiles', function () {
    $f = EmailFile::create(['file' => 'file']);
    $email = Email::create(['file_id' => $f->id]);

    $F = $email->emailFile;
    expect($F)->not->toBeNull();
    expect($F->id)->toBe($f->id);
});

it('has sequence', function () {
    $sequence = Sequence::name('test');
    $email = Email::create([
        'file_id' => 1,
        'sequence_id' => $sequence->id,
     ]);

    $Sequence = $email->sequence;
    expect($Sequence)->not->toBeNull();
    expect($Sequence->id)->toBe($sequence->id);
});


test('name retrieves existing email', function () {
    $f = EmailFile::create(['file' => 'test']);
    $email = Email::create(['file_id' => $f->id]);

    $Email = Email::name('test');

    expect($Email)->not->toBeNull();
    expect($Email->id)->toBe($email->id);

});

test('name creates a new email', function () {
    $f = EmailFile::create(['file' => 'test']);

    $Email = Email::name('test');

    expect($Email)->not->toBeNull();
    expect($Email->emailFile->id)->toBe($f->id);
    expect($Email->sequence)->toBe(null);

});

test('accepts sequence string', function () {
    $f = EmailFile::create(['file' => 'test']);

    $Email = Email::name('test', 'sequence');

    expect($Email)->not->toBeNull();
    expect($Email->emailFile->id)->toBe($f->id);
    expect($Email->sequence->id)->not->toBeNull();

});
