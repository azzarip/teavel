<?php

use Illuminate\Support\Carbon;
use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Sequence;


it('adds contact to a sequence', function () {
    $contact = Contact::factory()->create();
    $sequence = Sequence::name('test');

    $sequence->start($contact);

    $this->assertDatabaseHas('contact_sequence', [
        'contact_id' => $contact->id,
       'sequence_id' => $sequence->id,
    ]);
});

it('does not renew a contact if it exists', function () {
    $fixedTime = Carbon::create(2024, 7, 21, 12, 0, 0);
    Carbon::setTestNow($fixedTime);

    $contact = Contact::factory()->create();
    $sequence = Sequence::name('test');
    $sequence->start($contact);

    $advancedTime = $fixedTime->copy()->addHour();
    Carbon::setTestNow($advancedTime);

    $sequence->start($contact);


    $this->assertDatabaseHas('contact_sequence', [
        'contact_id' => $contact->id,
       'sequence_id' => $sequence->id,
       'created_at' => $fixedTime
    ]);
});

it('stops the sequence', function () {
    $contact = Contact::factory()->create();
    $sequence = Sequence::name('test');

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

it('renews a sequence if it has been stopped', function () {
    $contact = Contact::factory()->create();
    $sequence = Sequence::name('test');

    $sequence->start($contact);
    $sequence->stop($contact);
    $sequence->start($contact);

    $pivot = $contact->sequences()->where('sequence_id', $sequence->id)->first()->pivot;
    expect($pivot->stopped_at)->toBeNull();
});
