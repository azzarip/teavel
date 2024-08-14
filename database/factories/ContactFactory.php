<?php

namespace Azzarip\Teavel\Database\Factories;

use Azzarip\Teavel\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'marketing_at' => now(),
            'opt_in' => true,
        ];
    }
}
