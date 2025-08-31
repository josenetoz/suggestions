<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum Status: string implements HasLabel
{
    case Draft = 'draft';

    case InProgress = 'in-progress';

    case Finished = 'finished';

    public function getLabel(): string | Htmlable | null
    {
        return match ($this) {
            self::Draft      => __('status.draft'),
            self::Finished   => __('status.finished'),
            self::InProgress => __('status.in_progress'),
        };
    }
}
