<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Randomly pick gender
        // $gender = $this->faker->randomElement(['Male', 'Female']);
        $gender = $this->faker->randomElement(['Male']);

        // Faker first name according to gender
        $firstName = $gender === 'Male'
            ? $this->faker->firstNameMale()
            : $this->faker->firstNameFemale();

        // Middle and last names (generic random names)
        $middleName = $this->faker->firstNameMale();
        $lastName = $this->faker->lastName();

        // Random date of birth (1 to 23 years old)
        $dob = $this->faker->dateTimeBetween('-40 years', '-16 years')->format('Y-m-d');

        return [
            'first_name'  => $firstName,
            'middle_name' => $middleName,
            'last_name'   => $lastName,
            'gender'         => $gender,
            'dob'         => $dob,
        ];
    }
}
