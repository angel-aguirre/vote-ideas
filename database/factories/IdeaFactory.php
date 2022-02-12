<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class IdeaFactory extends Factory
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
            'category_id' => Category::factory(),
            'status_id' => Status::factory(),
            'title' => Str::ucfirst($this->faker->words(4, true)),
            'description' => $this->faker->paragraph(5),
        ];
    }

    public function existing() {
        return $this->state(function (array $attributes) {
            return [
                'user_id' => function() {
                    return User::query()->inRandomOrder()->first()->id;
                },
                'category_id' => function() {
                    return Category::query()->inRandomOrder()->first()->id;
                },
                'status_id' => function() {
                    return Status::query()->inRandomOrder()->first()->id;
                },
            ];
        });
    }
}
