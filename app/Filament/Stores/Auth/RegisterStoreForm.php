<?php

namespace App\Filament\Stores\Auth;

use App\Models\Store;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\{Hash, DB, Auth};
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;

class RegisterStoreForm extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form->schema([
            FileUpload::make('picture')
                ->label('Foto')
                ->avatar()
                ->disk('local')
                ->storeFiles(false)
                ->preserveFilenames(),

            TextInput::make('name')
                ->label('Nome do Estabelecimento')
                ->required()
                ->maxLength(255),

            TextInput::make('phone')
                ->label('Telefone')
                ->required()
                ->mask('(99) 99999-9999')
                ->minLength(14)
                ->maxLength(15),

            TextInput::make('cnpj')
                ->label('CNPJ')
                ->required()
                ->mask('99.999.999/9999-99')
                ->minLength(18)
                ->maxLength(18),

            TextInput::make('email')
                ->label('E-mail')
                ->email()
                ->required()
                ->unique('users', 'email'),

            TextInput::make('password')
                ->label('Senha')
                ->password()
                ->revealable()
                ->required()
                ->minLength(8)
                ->same('password_confirmation')
                ->rules([
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[\W]/'
                ])
                ->validationAttribute('password'),

            TextInput::make('password_confirmation')
                ->label('Confirme a Senha')
                ->password()
                ->revealable()
                ->required(),
        ]);
    }


    public function register(): ?RegistrationResponse
    {
        $data = $this->form->getState();
        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'picture' => $data['picture'],
            ]);
            $path = $data['picture']->store('profile-pictures', 'public');
            $user->update(['picture' => $path]);
            Store::create([
                'cnpj' => $data['cnpj'],
                'user_id' => $user->id,
            ]);
            Auth::login($user);
        });
        return app(RegistrationResponse::class);
    }

}
