<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * Define the model for the factory.
     *
     * @return string
     */
    public function model()
    {
        return Author::class;
    }

    /**
     * Define the states for the factory.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'biography' => join(" ", $this->faker->sentences(rand(3, 5))),
            'gender' => rand(1, 6) % 2 === 0 ? 'male' : 'female',
        ];
    }
}
