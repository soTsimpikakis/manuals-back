<?php

namespace Database\Factories;

use App\Models\Manual;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manual>
 */
class ManualFactory extends Factory
{

    protected $model = Manual::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'min_duration' => fake()->numberBetween(5,25),
            'max_duration' => fake()->numberBetween(15,45),
            'questions' => fake()->sentences(),
            'author_id' => User::factory(),
        ];
    }
}
