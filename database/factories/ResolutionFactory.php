<?php

namespace Database\Factories;

use App\Enums\ResolutionStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resolution>
 */
class ResolutionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => $this->faker->sentence(),
            // tag is a Char and a number
            "tag" => $this->faker->randomLetter() . $this->faker->numberBetween(1, 9),
            "year" => $this->faker->year(),
            "text" => $this->faker->text(),
            "status" => $this->faker->randomElement(ResolutionStatus::cases()),
            "category_id" => \App\Models\Category::inRandomOrder()->first()->id,
            "council_id" => \App\Models\Council::inRandomOrder()->first()->id,
        ];
    }
}
