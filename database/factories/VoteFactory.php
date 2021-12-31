<?php

namespace Database\Factories;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function() {
                return User::query()->inRandomOrder()->first()->id;
            },
            'idea_id' => function() {
                return Idea::query()->inRandomOrder()->first()->id;
            },
        ];
    }
}
