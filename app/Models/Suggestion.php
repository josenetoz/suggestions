<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Suggestion extends Model
{
    use HasComments;
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => Status::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function hasVotedByUser(User $user): bool
    {
        return $this->votes->contains('user_id', $user->id);
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'description'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $eventName) => match($eventName) {
                'created' => 'Sugestão criada',
                'updated' => 'Sugestão atualizada',
                'deleted' => 'Sugestão excluída',
                default   => $eventName
            });
    }

    protected static function booted()
    {
        static::created(function ($suggestion) {
            // Automatically create a vote for the creator
            $suggestion->votes()->create(['user_id' => $suggestion->user_id]);
        });
    }
}
