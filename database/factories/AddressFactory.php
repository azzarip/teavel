<?php

namespace Azzarip\Teavel\Database\Factories;

use Azzarip\Teavel\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName() . ' ' . fake()->lastName(),
            'contact_id' => fake()->numberBetween(1, Contact::count()),
            'address' => fake()->streetName() . ' ' . fake()->numberBetween(1, 199),
            'plz' => fake()->numberBetween(1000, 9999),
            'city' => fake()->city(),
        ];
    }
}
