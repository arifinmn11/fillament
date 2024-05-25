<?php

namespace App\Filament\Auth;

use App\Models\Cabang;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Select;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class Login extends BaseAuth
{
    protected $email;
    protected $cabang_id;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                $this->getLoginFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getLoginFormComponent(): Component
    {
        return Select::make('cabang_id')
            ->label('Cabang')
            ->options(Cabang::all()->pluck('nama', 'id'))
            ->required()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {

        $this->email = $data['email'];
        $this->cabang_id  = $data['cabang_id'];

        return [
            'email' => $data['email'],
            'password'  => $data['password'],
        ];
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $response = parent::authenticate();

            $user = User::where('email', $this->email)
                ->first();

            $user->update(['cabang_id' => $this->cabang_id]);

            return $response;
        } catch (ValidationException) {
            throw ValidationException::withMessages([
                'data.login' => __('filament-panels::pages/auth/login.messages.failed'),
            ]);
        }
    }
}
