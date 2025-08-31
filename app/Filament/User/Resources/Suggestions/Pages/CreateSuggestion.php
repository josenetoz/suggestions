<?php

namespace App\Filament\User\Resources\Suggestions\Pages;

use App\Enums\Status;
use App\Filament\User\Resources\Suggestions\SuggestionResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Alignment;

class CreateSuggestion extends CreateRecord
{
    protected static string $resource = SuggestionResource::class;

    public static string | Alignment $formActionsAlignment = Alignment::End;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['status']  = Status::Draft;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
