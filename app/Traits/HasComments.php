<?php

namespace App\Traits;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasComments
{
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->with('user')
            ->latest();
    }

    public function getCommentsCountAttribute(): int
    {
        return $this->comments()->count();
    }
}
