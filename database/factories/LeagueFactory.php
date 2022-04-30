<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LeagueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word. ' Football League',
            'description' => $this->faker->text,
            'poster_url' => 'https://en.baaghitv.com/wp-content/uploads/2021/01/FF9BE154-212B-4B94-AEBA-45E704E4F6CF.jpeg'
        ];
    }
}
