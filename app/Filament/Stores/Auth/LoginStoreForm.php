<?php

namespace App\Filament\Stores\Auth;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Notifications\Notification;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;

class LoginStoreForm extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();
            return null;
        }
        $data = $this->form->getState();
        if (!Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }
        $user = Filament::auth()->user();
        if (!Store::where('user_id', $user->id)->exists()) {
            Filament::auth()->logout();

            Notification::make()
                ->title('Erro no login')
                ->body('Loja não registrada, por favor crie uma conta.')
                ->danger()
                ->send();
            $this->throwFailureValidationException();
        }
        session()->regenerate();
        return app(LoginResponse::class);
    }
}