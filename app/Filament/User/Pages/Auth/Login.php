<?php

namespace App\Filament\User\Pages\Auth;

use App\Models\{User};
use Exception;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BasePage;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class Login extends BasePage
{
    /**
     * @throws Exception
     */
    public function form(Schema $schema): Schema
    {
        if (app()->environment('local')) {
            $schema->components([
                Select::make('user')
                    ->label('Usuário')
                    ->required()
                    ->searchable()
                    ->options(
                        User::all()
                            ->pluck('name', 'email')
                            ->toArray()
                    ),
            ]);

            return $schema;
        }

        return parent::form($schema);
    }

    public function authenticate(): ?LoginResponse
    {
        if (app()->environment('local')) {

            $authenticateAs = $this->form->getState()['user'] ?? null;

            auth()->login(
                User::query()
                    ->where('email', $authenticateAs)->first()
            );

            return app(LoginResponse::class);
        }

        return parent::authenticate();
    }

}
