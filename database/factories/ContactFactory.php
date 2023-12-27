<?php

namespace Azzarip\Teavel\Database\Factories;

use Azzarip\Teavel\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        return [
            'name' => fake()->firstName,
            'surname' => fake()->lastName,
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
