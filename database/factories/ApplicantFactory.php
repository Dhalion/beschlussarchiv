<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Applicant>
 */
class ApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customNames = [
            "Landesvorstand"
        ];
        return [
            'name' => $this->faker->randomElement(array_merge($customNames, [$this->faker->city])),
            'council_id' => \App\Models\Council::inRandomOrder()->first()->id,
        ];
    }
}
