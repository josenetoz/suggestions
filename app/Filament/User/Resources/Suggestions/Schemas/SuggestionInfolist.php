<?php

namespace App\Filament\User\Resources\Suggestions\Schemas;

use Exception;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\{Section};
use Filament\Schemas\Schema;

class SuggestionInfolist
{
    /**
     * @throws Exception
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('suggestions.suggestion'))
                    ->description(fn ($record) => __('suggestions.created_by') . ': ' . $record->user->name)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('title')
                            ->columnSpanFull()
                            ->label(__('suggestions.title')),
                        TextEntry::make('description')
                            ->columnSpanFull()
                            ->label(__('suggestions.description')),
                    ])
                    ->columns(2),
            ]);
    }
}
