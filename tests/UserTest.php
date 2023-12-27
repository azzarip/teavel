<?php

use Azzarip\Teavel\Tests\TestModels\User;
use Azzarip\Teavel\Tests\TestModels\UserFactory;

it('has full name', function () {
    $user = UserFactory::new()->create([
        'name' => 'Name',
        'surname' => 'Surname',
    ]);
    expect($user->fullName)->toBe('Name Surname');
});