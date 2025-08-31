<?php

namespace App\Filament\User\Resources\Suggestions\Tables;

use App\Enums\Status;
use App\Filament\User\Resources\Suggestions\SuggestionResource;
use App\Models\Suggestion;
use Exception;
use Filament\Actions\{Action, ActionGroup, DeleteAction, EditAction, RestoreAction};
use Filament\Forms\Components\Select;
use Filament\Support\Enums\{TextSize, Width};
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\{TextColumn};
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\{Builder, Model};

class SuggestionsTable
{
    /**
     * @throws Exception
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn (Builder $query) => $query
                    ->withCount('votes')
                    ->with(['user', 'votes'])
            )
            ->columns([
                TextColumn::make('votes_count')
                    ->label(__('suggestions.votes'))
                    ->badge()
                    ->size(TextSize::Large)
                    ->formatStateUsing(fn (Suggestion $record): string => $record->votes_count)
                    ->icon(Heroicon::ArrowUp)
                    ->color(
                        fn (Suggestion $record) => $record->hasVotedByUser(auth()->user()) ? 'info' : 'gray'
                    )
                    ->action(function (Suggestion $record): void {
                        $user = auth()->user();

                        $record->hasVotedByUser($user)
                            ? $record->votes()->where('user_id', $user->id)->delete()
                            : $record->votes()->create(['user_id' => $user->id]);
                    }),

                TextColumn::make('title')
                    ->label(__('suggestions.title'))
                    ->description(fn (Model $record) => __('suggestions.created_by') . ': ' . $record->user->name)
                    ->tooltip(__('suggestions.click_to_view_details'))
                    ->searchable()
                    ->wrap(),

                TextColumn::make('comments_count')
                    ->label(' ')
                    ->formatStateUsing(fn (Suggestion $record): string => $record->comments_count . ' ' . __('comments.comments'))
                    ->description(fn (Model $record) => __('suggestions.click_to_view_details'))
                    ->icon(Heroicon::ChatBubbleBottomCenterText)
                    ->color('gray'),

            ])
            ->filters([

                //
            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('changeStatus')
                        ->label(__('suggestions.change_status'))
                        ->icon(Heroicon::ArrowPath)
                        ->color('info')
                        ->modalWidth(Width::Large)
                        ->schema([
                            Select::make('status')
                                ->label(__('suggestions.status'))
                                ->default(fn (Model $record) => $record->status->value)
                                ->searchable()
                                ->preload()
                                ->options(Status::class)
                                ->required(),
                        ])
                        ->action(
                            function (Model $record, array $data): void {
                                $record->update($data);
                            }
                        ),
                    EditAction::make(),
                    Action::make('activities')
                        ->icon(Heroicon::ListBullet)
                        ->label(__('suggestions.activities'))
                        ->url(fn ($record) => SuggestionResource::getUrl('activities', ['record' => $record])),
                    DeleteAction::make(),
                    RestoreAction::make(),
                ])
                    ->visible(fn() => auth()->user()->hasRole('admin'))
                    ->icon(Heroicon::Cog6Tooth)
                    ->size('sm')
                    ->label(false)
                    ->button(),

            ])
            ->toolbarActions([
                //
            ])
            ->defaultSort('votes_count', 'desc')
            ->recordUrl(
                fn (Suggestion $record): string => SuggestionResource::getUrl('view', ['record' => $record])
            );
    }
}
