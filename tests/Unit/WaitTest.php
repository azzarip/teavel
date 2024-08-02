<?php

use Azzarip\Teavel\Automations\Wait;
use Carbon\Carbon;

it('waits until X', function() {
    $wait = Wait::until('1.5.2024 19:00');
    expect($wait->timestamp)->toBeInstanceOf(Carbon::class);
    expect($wait->timestamp->format('Y'))->toBe('2024');
});

it('gets a new step', function() {
    $wait = Wait::until('1.5.2024 19:00')->then('test');
    expect($wait->step)->toBe('test');
});

it('has is_past attribute', function() {
    $wait = Wait::until('1.1.2024 19:00');
    expect($wait->IsPast())->toBeTrue();

    $wait = Wait::until(Carbon::now()->addDays(1));
    expect($wait->IsPast())->toBeFalse();
});

it('adds RandomMinutes', function() {
    $wait = Wait::carbon(now())->addRandomMinutes();
    expect($wait->timestamp->lessThan(now()->addMinutes(16)))->toBeTrue();
});

it('automatically adds random Minutes', function() {
    $wait = Wait::carbon(now());
    expect($wait->timestamp->format('i'))->not->toBe($wait->getRandomizedTimestamp()->format('i'));
});
