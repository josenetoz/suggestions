<?php

namespace App\Filament\User\Resources\Suggestions\Pages;

use App\Filament\User\Resources\Suggestions\SuggestionResource;
use Filament\Actions\{ViewAction};
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Alignment;

class EditSuggestion extends EditRecord
{
    protected static string $resource = SuggestionResource::class;

    public static string | Alignment $formActionsAlignment = Alignment::End;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
