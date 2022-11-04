<?php

namespace Database\Factories;

use App\Enums\StudentStatusEnum;
use App\Models\Course;
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
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'gender' => $this->faker->boolean(),
            'birthdate' => $this->faker->dateTimeBetween('-30 years', '-18 years'),
            'status' => $this->faker->randomElement(StudentStatusEnum::asArray()),
            'course_id' => Course::inRandomOrder()->value('id'),
        ];
    }
}