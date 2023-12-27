<?php

use Azzarip\Teavel\Tests\TestModels\User;

it('can test', function () {
    $user = User::create([
        'name' => ' ::name::',
        'surname' => '::surname::',
        'email' => '::email::',
    ]);
    dd($user);
    expect(true)->toBeTrue();
});
