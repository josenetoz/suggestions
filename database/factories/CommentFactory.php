<?php

namespace Database\Factories;

use App\Models\{Comment, Suggestion, User};
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'user_id'          => User::factory(),
            'commentable_type' => Suggestion::class,
            'commentable_id'   => Suggestion::factory(),
            'text'             => fake()->sentence(),
        ];
    }
}
