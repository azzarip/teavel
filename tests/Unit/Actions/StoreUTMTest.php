<?php

use Azzarip\Teavel\Actions\StoreUTM;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

it('returns null if data is empty', function () {
    expect(StoreUTM::store([]))->toBeNull();
    expect(Session::has('utm'))->toBeFalse();

});

it('stores a key in the utm session', function () {
    $data = ['source' => '::source::'];
    StoreUTM::store($data);

    expect(Session::has('utm'))->toBeTrue();
    expect(Cache::get(Session::get('utm')))->toBe($data);
});