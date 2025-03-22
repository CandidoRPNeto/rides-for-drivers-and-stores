<?php

namespace App\Filament\Stores\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class PurchasePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Comprar Corridas';
    protected static ?string $slug = 'comprar';
    protected static ?int $navigationSort = 10;
    protected static string $view = 'filament.pages.purchase';

    public function form(Form $form): Form
    {
        return $form->schema([
            Select::make('item')
                ->label('Escolha um item')
                ->options([
                    'plano_basico' => 'Plano Básico - R$ 29,90',
                    'plano_premium' => 'Plano Premium - R$ 59,90',
                ])
                ->required(),

            TextInput::make('quantidade')
                ->label('Quantidade')
                ->numeric()
                ->minValue(1)
                ->default(1)
                ->required(),
        ]);
    }

    public function buy()
    {
        $data = $this->form->getState();
        $user = Auth::user();

        // Simular um processamento de compra
        $mensagem = "Compra realizada com sucesso! Item: " . $data['item'] . ", Quantidade: " . $data['quantidade'];

        Notification::make()
            ->title('Compra Confirmada')
            ->body($mensagem)
            ->success()
            ->send();
    }

    protected function getActions(): array
    {
        return [
        ];
    }
}
