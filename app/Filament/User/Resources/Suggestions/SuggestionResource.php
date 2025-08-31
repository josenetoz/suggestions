<?php

namespace App\Filament\User\Resources\Suggestions;

use App\Filament\User\Resources\Suggestions\Pages\{CreateSuggestion,
    EditSuggestion,
    ListSuggestions,
    ListSuggestionsActivities,
    ViewSuggestion};
use App\Filament\User\Resources\Suggestions\RelationManagers\CommentsRelationManager;
use App\Filament\User\Resources\Suggestions\Schemas\{SuggestionForm, SuggestionInfolist};
use App\Filament\User\Resources\Suggestions\Tables\SuggestionsTable;
use App\Models\Suggestion;
use Exception;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SuggestionResource extends Resource
{
    protected static ?string $model = Suggestion::class;

    protected static ?string $label = null;

    public static function getLabel(): ?string
    {
        return __('suggestions.suggestion');
    }

    protected static ?string $pluralLabel = null;

    public static function getPluralLabel(): ?string
    {
        return __('suggestions.suggestions');
    }

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = '/';

    protected static ?string $recordTitleAttribute = 'title';

    /**
     * @throws Exception
     */
    public static function form(Schema $schema): Schema
    {
        return SuggestionForm::configure($schema);
    }

    /**
     * @throws Exception
     */
    public static function infolist(Schema $schema): Schema
    {
        return SuggestionInfolist::configure($schema);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return SuggestionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListSuggestions::route('/'),
            'create' => CreateSuggestion::route('/create'),
            'view'   => ViewSuggestion::route('/{record}'),
            'activities' => ListSuggestionsActivities::route('/{record}/activities'),
            'edit'   => EditSuggestion::route('/{record}/edit'),
        ];
    }

}
