<?php

use Azzarip\Teavel\Models\Email;
use Azzarip\Teavel\Models\Sequence;
use Azzarip\Teavel\Models\EmailFile;

beforeEach(function() {
    $this->f = EmailFile::create(['file' => 'test']);
});

it('has emailfiles', function () {
    $email = Email::create(['file_id' => $this->f->id]);

    $F = $email->emailFile;
    expect($F)->not->toBeNull();
    expect($F->id)->toBe($this->f->id);
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
    $email = Email::create(['file_id' => $this->f->id]);

    $Email = Email::name('test');

    expect($Email)->not->toBeNull();
    expect($Email->id)->toBe($email->id);

});

test('name creates a new email', function () {

    $Email = Email::name('test');

    expect($Email)->not->toBeNull();
    expect($Email->emailFile->id)->toBe($this->f->id);
    expect($Email->sequence)->toBe(null);

});

test('accepts sequence string', function () {
    $Email = Email::name('test', 'sequence');

    expect($Email)->not->toBeNull();
    expect($Email->emailFile->id)->toBe($this->f->id);
    expect($Email->sequence->id)->not->toBeNull();

});

it('has UUID', function () {
    $email1 = Email::name('test');
    $email2 = Email::findUuid($email1->uuid);
    expect($email1->id)->toBe($email2->id);
});
