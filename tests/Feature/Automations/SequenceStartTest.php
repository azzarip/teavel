<?php

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Sequence;
use Illuminate\Support\Carbon;

beforeEach(function () {
    $this->mock = \Mockery::mock('alias:App\Teavel\Automations\SequenceHandler');
});

it('calls the sequence start', function () {
    //$this->mock->shouldReceive('start')->once();

    $contact = Contact::factory()->create();
    $sequence = Sequence::name('test');

    $sequence->start($contact);
});

// it('adds contact to a sequence', function () {
//     $this->mock->shouldReceive('start');
//     $contact = Contact::factory()->create();
//     $sequence = Sequence::name('test');

//     $sequence->start($contact);

//     $this->assertDatabaseHas('contact_sequence', [
//         'contact_id' => $contact->id,
//         'sequence_id' => $sequence->id,
//     ]);
// });

// it('does not renew a contact if it exists', function () {
//     $fixedTime = Carbon::now();
//     Carbon::setTestNow($fixedTime);
//     $this->mock->shouldReceive('start')->once();

//     $contact = Contact::factory()->create();
//     $sequence = Sequence::name('test');
//     $sequence->start($contact);

//     $advancedTime = $fixedTime->copy()->addHour();
//     Carbon::setTestNow($advancedTime);

//     $sequence->start($contact);

//     $this->assertDatabaseHas('contact_sequence', [
//         'contact_id' => $contact->id,
//         'sequence_id' => $sequence->id,
//         'created_at' => $fixedTime,
//     ]);
// });

// it('renews a sequence if it has been stopped', function () {
//     $contact = Contact::factory()->create();
//     $sequence = Sequence::name('test');
//     $this->mock->shouldReceive('start')->twice();
//     $fixedTime = Carbon::now();
//     Carbon::setTestNow($fixedTime);

//     $sequence->start($contact);
//     $sequence->stop($contact);
//     $sequence->start($contact);

//     $pivot = $contact->sequences()->where('sequence_id', $sequence->id)->first()->pivot;
//     expect($pivot->stopped_at)->toBeNull();
//     expect($pivot->created_at)->toBe(now());
// });

// it('executes start method on the class', function () {
//     $this->mock->shouldReceive('start')->once();
//     $contact = Contact::factory()->create();
//     $sequence = Sequence::name('test');

//     $sequence->start($contact);
// });

// it('throws error on missing start method', function () {
//     $contact = Contact::factory()->create();
//     $sequence = Sequence::name('test');

//     $sequence->start($contact);

// })->throws(BadMethodCallException::class);

afterEach(function () {
    \Mockery::close();
});
