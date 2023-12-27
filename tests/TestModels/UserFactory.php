<?php

namespace Azzarip\Teavel\Tests\TestModels;

use Azzarip\Teavel\Tests\TestModels\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => fake()->firstName,
            'surname' => fake()->lastName,
            'email' => fake()->unique()->safeEmail,
        ];
    }
}