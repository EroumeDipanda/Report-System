<?php

namespace Database\Factories;

use App\Models\Classe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matricule' => $this->faker->unique()->numerify('MAT######'),
            'first_name' => $this->faker->unique()->firstName(),
            'last_name' => $this->faker->lastName(),
            'sex' => $this->faker->randomElement(['male', 'female']),
            'date_of_birth' => $this->faker->date(),
            'place_of_birth' => $this->faker->city(),
            'nationality' => $this->faker->country(),
            'parents_contact' => $this->faker->phoneNumber(),
            'photo' => $this->faker->imageUrl(640, 480, 'people', true, 'students'),
            'classe_id' => Classe::inRandomOrder()->first()->id, // Associate with an existing class
        ];
    }

}
