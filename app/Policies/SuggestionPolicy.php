<?php

namespace App\Policies;

use App\Models\{Suggestion, User};

class SuggestionPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Suggestion $suggestion): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Suggestion $suggestion): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Suggestion $suggestion): bool
    {
        return $user->isAdmin();
    }

    public function changeStatus(User $user, Suggestion $suggestion): bool
    {
        return $user->isAdmin();
    }

    public function viewLogs(User $user, Suggestion $suggestion): bool
    {
        return $user->isAdmin();
    }

    public function viewVotes(User $user, Suggestion $suggestion): bool
    {
        return $user->isAdmin();
    }
}
