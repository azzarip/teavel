<?php

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Sequence;
use Illuminate\Support\Carbon;
use Mockery as M;

beforeEach(function () {
    $this->mock = M::mock('alias:Azzarip\Teavel\SequenceManager');
});
it('calls the sequence start', function () {
    $this->mock->shouldReceive('start')->once();
    $contact = Contact::factory()->create();
    $sequence = Sequence::name('test');

    $sequence->start($contact);
});

it('adds contact to a sequence', function () {
    $this->mock->shouldReceive('start');
    $contact = Contact::factory()->create();
    $sequence = Sequence::name('test');

    $sequence->start($contact);

    $this->assertDatabaseHas('contact_sequence', [
        'contact_id' => $contact->id,
        'sequence_id' => $sequence->id,
    ]);
});

it('does not renew a contact if it exists', function () {
    $fixedTime = Carbon::now();
    Carbon::setTestNow($fixedTime);
    $this->mock->shouldReceive('start')->once();

    $contact = Contact::factory()->create();
    $sequence = Sequence::name('test');
    $sequence->start($contact);

    $advancedTime = $fixedTime->copy()->addHour();
    Carbon::setTestNow($advancedTime);

    $sequence->start($contact);

    $this->assertDatabaseHas('contact_sequence', [
        'contact_id' => $contact->id,
        'sequence_id' => $sequence->id,
        'created_at' => $fixedTime,
    ]);
});

it('stops the sequence', function () {
    $contact = Contact::factory()->create();
    $sequence = Sequence::name('test');
    $this->mock->shouldReceive('start');

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
    $this->mock->shouldReceive('start')->twice();

    $sequence->start($contact);
    $sequence->stop($contact);
    $sequence->start($contact);

    $pivot = $contact->sequences()->where('sequence_id', $sequence->id)->first()->pivot;
    expect($pivot->stopped_at)->toBeNull();
});
afterEach(function () {
    Mockery::close();
});
