<?php

namespace App\Filament\User\Resources\Suggestions\Pages;

use App\Enums\Status;
use App\Filament\User\Resources\Suggestions\SuggestionResource;
use App\Models\Suggestion;
use Filament\Actions\{Action, CreateAction};
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListSuggestions extends ListRecords
{
    protected static string $resource = SuggestionResource::class;

    protected function getHeaderActions(): array
    {
        if (Auth::check()) {
            return [
                CreateAction::make()
                    ->label(__('suggestions.make_suggestion'))
                    ->color('info')
                    ->iconPosition(IconPosition::After)
                    ->icon(Heroicon::LightBulb),
            ];
        }

        return [
            Action::make('login')
                ->label(__('Log in'))
                ->color('primary')
                ->iconPosition(IconPosition::After)
                ->icon(Heroicon::ArrowRightOnRectangle)
                ->url(route('filament.user.auth.login')),
            Action::make('register')
                ->label(__('Register'))
                ->color('gray')
                ->iconPosition(IconPosition::After)
                ->icon(Heroicon::UserPlus)
                ->url(route('filament.user.auth.register')),
        ];
    }

    public function getTabs(): array
    {
        return [
            'draft' => Tab::make(__('suggestions.suggestions'))
                ->badge(Suggestion::query()->where('status', Status::Draft)->count())
                ->badgeColor('primary')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Status::Draft)),
            'in_progress' => Tab::make(__('suggestions.in_progress'))
                ->badge(Suggestion::query()->whereNot('status', Status::Draft)->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNot('status', Status::Draft)),

            'finished' => Tab::make(__('suggestions.finished'))
                ->badge(Suggestion::query()->where('status', Status::Finished)->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Status::Finished)),

        ];

    }
}
