<?php

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Sequence;

it('stops the sequence', function () {
    $contact = Contact::factory()->create();
    $sequence = Sequence::name('test');
    $mock = \Mockery::mock('alias:Azzarip\Teavel\Automations\SequenceHandler');
    $mock->shouldReceive('start');

    $sequence->start($contact);

    $sequence->stop($contact);

    $pivot = $contact->sequences()->where('sequence_id', $sequence->id)->first()->pivot;
    expect($pivot->stopped_at)->not->toBeNull();
});

test('stop does not create a new sequence', function () {
    $contact = Contact::factory()->create();
    $sequence = Sequence::name('test');

    $sequence->stop($contact);

    $this->assertDatabaseMissing('contact_sequence', [
        'contact_id' => $contact->id,
        'sequence_id' => $sequence->id,
    ]);
});
