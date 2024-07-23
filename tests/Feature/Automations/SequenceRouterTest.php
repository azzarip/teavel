<?php

use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\SequenceRouter;
use Azzarip\Teavel\Models\Sequence;
use Azzarip\Teavel\Exceptions\TeavelException;
use Azzarip\Teavel\Exceptions\BadMethodCallException;

it('throws error on missing class', function () {
    SequenceRouter::start(Sequence::name('test'), Contact::factory()->create());
})->throws(TeavelException::class);

it('throws error on missing start method', function () {
    \Mockery::mock('alias:App\Teavel\Sequences\Test');
    SequenceRouter::start(Sequence::name('test'), Contact::factory()->create());
})->throws(BadMethodCallException::class);

it('executes start method on the class', function () {
    \Mockery::mock('alias:App\Teavel\Sequences\Test')->shouldReceive('start')->once();
    SequenceRouter::start(Sequence::name('test'), Contact::factory()->create());
});

afterEach(function () {
    \Mockery::close();
});
