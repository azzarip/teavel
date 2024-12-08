<?php

namespace Azzarip\Teavel\Database\Factories;

use Azzarip\Teavel\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OfferFactory extends Factory
{
    protected $model = Offer::class;

    public function definition(): array
    {
        return [
            'slug' => fake()->slug(),
            'class' => fake()->word(),
            'type_id' => 0,
        ];
    }
}
