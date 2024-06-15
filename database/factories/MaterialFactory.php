<?php

namespace Database\Factories;

use App\Models\Manual;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => fake()->words(3,true),
            'quantity' => fake()->numberBetween(0, 100),
            'unit' => fake()->randomElement(['cm','per person']),
            'manual_id' => Manual::factory()
        ];
    }
}
