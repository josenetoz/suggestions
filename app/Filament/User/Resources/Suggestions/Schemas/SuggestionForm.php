<?php

namespace App\Filament\User\Resources\Suggestions\Schemas;

use Exception;
use Filament\Forms\Components\{TextInput, Textarea};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SuggestionForm
{
    /**
     * @throws Exception
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->label(__('suggestions.title'))
                            ->required()
                            ->maxLength(255)
                            ->placeholder(__('suggestions.title_placeholder')),

                        Textarea::make('description')
                            ->label(__('suggestions.description'))
                            ->required()
                            ->rows(4)
                            ->placeholder(__('suggestions.description_placeholder'))
                            ->maxLength(1000),
                    ])
                    ->columns(1),
            ]);
    }
}
