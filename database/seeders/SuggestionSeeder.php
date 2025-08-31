<?php

namespace Database\Seeders;

use App\Models\{Suggestion, User, Vote};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class SuggestionSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);

        $admin = User::factory()->create([
            'name'  => 'Administrador',
            'email' => 'admin@exemplo.com',
        ]);
        $admin->assignRole($adminRole);

        $users = User::factory()->count(3)->create();
        $users->each(fn ($user) => $user->assignRole($userRole));

        $allUsers = User::all();

        $suggestions = Suggestion::factory()
            ->count(10)
            ->sequence(fn ($sequence) => [
                'user_id' => $allUsers->random()->id,
            ])
            ->create();

        foreach ($suggestions as $suggestion) {
            $otherUsers = $allUsers->where('id', '!=', $suggestion->user_id);
            $voters     = $otherUsers->random(rand(1, min(3, $otherUsers->count())));

            foreach ($voters as $voter) {
                Vote::factory()->create([
                    'user_id'       => $voter->id,
                    'suggestion_id' => $suggestion->id,
                ]);
            }
        }
    }
}
