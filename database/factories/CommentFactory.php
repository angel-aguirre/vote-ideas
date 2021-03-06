<?php

namespace Database\Factories;

use App\Models\Idea;
use App\Models\User;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'idea_id' => Idea::factory(),
            'status_id' => Status::factory(),
            'body'    => $this->faker->paragraph(5),
        ];
    }

    public function existing() {
        return $this->state(function (array $attributes) {
            return [
                'user_id' => function() {
                    return User::query()->inRandomOrder()->first()->id;
                },
                'idea_id' => function() {
                    return Idea::query()->inRandomOrder()->first()->id;
                },
                'status_id' => function() {
                    return null;
                }
            ];
        });
    }
}
