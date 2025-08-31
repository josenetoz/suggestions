<?php

namespace App\Filament\User\Resources\Suggestions\Pages;

use App\Filament\User\Resources\Suggestions\SuggestionResource;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class ListSuggestionsActivities extends ListActivities
{
    protected static string $resource = SuggestionResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()->can('viewLogs', $parameters['record'] ?? null);
    }
}
