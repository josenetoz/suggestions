<?php

namespace Database\Factories;

use App\Models\{Suggestion, User};
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'       => User::factory(),
            'suggestion_id' => Suggestion::factory(),
        ];
    }
}
