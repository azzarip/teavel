<?php

namespace Azzarip\Teavel\Database\Factories;

use Illuminate\Support\Str;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'email' => fake()->unique()->safeEmail(),
            'uuid' => Str::uuid(),
        ];
    }
}
