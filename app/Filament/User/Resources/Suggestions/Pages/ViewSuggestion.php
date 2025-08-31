<?php

namespace App\Filament\User\Resources\Suggestions\Pages;

use App\Filament\User\Resources\Suggestions\SuggestionResource;
use Filament\Resources\Pages\ViewRecord;

class ViewSuggestion extends ViewRecord
{
    protected static string $resource = SuggestionResource::class;

    protected static ?string $title = null;

    public function getTitle(): string
    {
        return __('suggestions.view_suggestion');
    }

    protected static ?string $breadcrumb = null;

    public function getBreadcrumb(): string
    {
        return __('suggestions.view');
    }
}
