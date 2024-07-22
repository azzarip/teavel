<?php

use Azzarip\Teavel\Models\Sequence;



it('returns sequence by name', function () {
    $sequence1 = Sequence::create(['name' => 'test']);
    $sequence2 = Sequence::name('test');

    expect($sequence1->id)->toBe($sequence2->id);
});

it('creates a new sequence if does not exist', function () {
    Sequence::name('test');

    expect(Sequence::count())->toBe(1);
});
