<?php

namespace App\Filament\Stores\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;

class StoreSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Configurações';
    protected static ?string $slug = 'settings';
    protected static ?int $navigationSort = 999;
    protected static string $view = 'filament.pages.store-settings';

    public function mount()
    {
        $user = Auth::user();

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Nome')
                ->maxLength(255),

            TextInput::make('email')
                ->label('E-mail')
                ->email(),

            FileUpload::make('picture')
                ->label('Foto de Perfil')
                ->image()
                ->directory('profile-photos')
                ->columnSpanFull(),

            TextInput::make('password')
                ->label('Nova Senha')
                ->password()
                ->minLength(8)
                ->nullable(),

            TextInput::make('password_confirmation')
                ->label('Confirme a Nova Senha')
                ->password()
                ->same('password')
                ->nullable(),
        ])
        ->columns(2);
    }

    public function save()
    {
        $data = $this->form->getState();
        $user = Auth::user();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if (!empty($data['photo'])) {
            $user->update(['photo' => $data['photo']]);
        }

        $user->update($data);

        Notification::make()
            ->title('Configurações Atualizadas')
            ->success()
            ->send();
    }
}
