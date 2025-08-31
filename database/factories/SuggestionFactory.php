<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\{Comment, User};
use Illuminate\Database\Eloquent\Factories\Factory;

class SuggestionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'       => fake()->sentence(4),
            'description' => fake()->paragraph(3),
            'status'      => Status::Draft,
            'user_id'     => User::factory(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function ($suggestion) {
            Comment::factory()
                ->count(20)
                ->forSuggestion($suggestion)
                ->create();
        });
    }
}
