<?php

use Azzarip\Teavel\Models\ContactSequence;

it('gets the ready steps and runs them', function () {

    ContactSequence::create([
        'contact_id' => 1,
        'sequence_id' => 1,
        'execute_at' => now()->subDay(),
    ]);

    $mock = \Mockery::mock('alias:Azzarip\Teavel\Automations\SequenceHandler');
    $mock->shouldReceive('handle')->once();

    $this->artisan('teavel:run');
});

it('sets the ready steps to stalled', function () {

    ContactSequence::create([
        'contact_id' => 1,
        'sequence_id' => 1,
        'execute_at' => now()->subDay(),
    ]);

    \Mockery::mock('alias:Azzarip\Teavel\Automations\SequenceHandler');

    $this->artisan('teavel:run');

    $pivot = ContactSequence::first();

    expect($pivot->execute_at)->toBeNull();
});
