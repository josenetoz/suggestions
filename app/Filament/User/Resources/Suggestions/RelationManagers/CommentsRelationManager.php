<?php

namespace App\Filament\User\Resources\Suggestions\RelationManagers;

use Exception;
use Filament\Actions\{CreateAction};
use Filament\Forms\Components\{Textarea};
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\{Alignment, IconPosition, Width};
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $title = '';

    public function isReadOnly(): bool
    {
        return false;
    }

    /**
     * @throws Exception
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Textarea::make('text')
                    ->label(__('comments.comment'))
                    ->helperText(__('comments.max_characters'))
                    ->maxLength(255)
                    ->required(),
            ]);
    }

    /**
     * @throws Exception
     */
    public function table(Table $table): Table
    {
        return $table
            ->paginated([10, 25, 50])
            ->recordTitleAttribute('text')
            ->emptyStateDescription(false)
            ->emptyStateHeading(__('comments.no_comments'))
            ->columns([
                TextColumn::make('text')
                    ->wrap()
                    ->description(fn ($record) => $record->user->name . ' - ' . $record->created_at->diffForHumans())
                    ->label(__('comments.comment')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('comments.create_comment'))
                    ->color('info')
                    ->modalHeading('')
                    ->modalWidth(Width::Large)
                    ->modalFooterActionsAlignment(Alignment::End)
                    ->icon(Heroicon::ChatBubbleBottomCenterText)
                    ->iconPosition(IconPosition::After)
                    ->mutateDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();

                        return $data;
                    }),

            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                //
            ]);
    }
}
