<?php

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Sequence;
use Azzarip\Teavel\Models\ContactSequence;

it('has is_stopped attribute', function () {
    $pivot = new ContactSequence();

    expect($pivot->is_stopped)->toBe(false);

    $pivot->stopped_at = now();

    expect($pivot->is_stopped)->toBe(true);

});

it('has is_active attribute', function () {
    $pivot = new ContactSequence();

    expect($pivot->is_active)->toBe(true);

    $pivot->stopped_at = now();

    expect($pivot->is_active)->toBe(false);
});

it('resets', function () {
    $pivot = new ContactSequence();
    $pivot->contact_id = 1;
    $pivot->sequence_id = 1;

    $pivot->stopped_at = now();
    $pivot->execute_at = now();
    $pivot->created_at = now()->subDay();
    $pivot->step = '::step::';

    $pivot->reset();

    expect($pivot->stopped_at)->toBeNull();
    expect($pivot->execute_at)->toBeNull();
    expect($pivot->step)->toBeNull();
    expect($pivot->created_at->equalTo(now()->startOfSecond()));
});

it('has is_stalled attribute', function () {
    $pivot = new ContactSequence();

    $pivot->step = '::step::';
    $pivot->updated_at = now()->subDay();

    expect($pivot->is_stalled)->toBeTrue();
});

it('has is_working attribute', function () {
    $pivot = new ContactSequence();

    $pivot->step = '::step::';
    $pivot->updated_at = now()->subMinute();

    expect($pivot->is_working)->toBeTrue();
});

it('has is_waiting attribute', function () {
    $pivot = new ContactSequence();

    $pivot->execute_at = now();
    $pivot->step = '::step::';

    expect($pivot->is_waiting)->toBeTrue();
});

it('pulls the ready pivots', function () {
    $contacts = Contact::factory(4)->create();
    $sequence = Sequence::name('test_1');

    $pivot1 = ContactSequence::create([
        'contact_id' => $contacts[0]->id,
       'sequence_id' => $sequence->id,
        'execute_at' => now()->subMinute(),
    ]);

    $pivot2 = ContactSequence::create([
        'contact_id' => $contacts[1]->id,
       'sequence_id' => $sequence->id,
        'execute_at' => now()->addDay(),
    ]);

    $pivot3 = ContactSequence::create([
        'contact_id' => $contacts[2]->id,
       'sequence_id' => $sequence->id,
    ]);

    $pivot4 = ContactSequence::create([
        'contact_id' => $contacts[3]->id,
       'sequence_id' => $sequence->id,
       'stopped_at' => now()->subDay(),
    ]);

    $ready = ContactSequence::ready();


    expect($ready)->toHaveCount(1);
    expect($ready->pluck('execute_at'))->not->toContain(null);
    expect($ready->pluck('stopped_at'))->toContain(null);
});
