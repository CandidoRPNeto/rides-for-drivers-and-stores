<?php

namespace App\Filament\Stores\Resources;

use App\Filament\Stores\Resources\DealerResource\Pages;
use App\Filament\Stores\Resources\DealerResource\RelationManagers;
use App\Models\Dealer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DealerResource extends Resource
{
    protected static ?string $model = Dealer::class;

    protected static ?string $navigationIcon = 'gmdi-sports-motorsports-o';

    protected static ?string $label = 'Entregador';

    protected static ?string $pluralLabel = 'Entregadores';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('10s')
            ->columns([
                ImageColumn::make('user.picture')
                ->label('Foto')
                ->circular()
                ->size(40),
                TextColumn::make('user.name')->label('Nome'),
                TextColumn::make('status')
                ->badge()
                ->sortable()
                ->formatStateUsing(fn ($state) => match ((int) $state) {
                    1 => 'disponível',
                    2 => 'corrida atribuida',
                    3 => 'em trânsito',
                    4 => 'indisponível'
                })
                ->color(fn (string $state): string => match ((int) $state) {
                    1 => 'success',
                    2 => 'gray',
                    3 => 'warning',
                    4 => 'danger'
                }),

            ])
            ->paginated([5, 10, 20, 50])
            ->actions([
                Tables\Actions\EditAction::make(),
                ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('dealer')
                    ->label('Convidar Entregador')
                    ->color('primary')
                    ->modalHeading('Selecionar Entregadores')
                    ->modalButton('Enviar Convite')
                    ->modalWidth('lg')
                    ->form(fn() => self::getDealerListForm())
                    ->action(fn () => static::sendInvite()),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDealers::route('/'),
        ];
    }

    private static function sendInvite()
    {
        return ;
    }
    public static function getDealerListForm(): array
    {
        return [
            Forms\Components\Select::make('dealers')
                ->label('Selecione os entregadores para convidar')
                ->searchable()
                ->multiple()
                ->options(
                    Dealer::whereHas('user')
                        ->with('user')
                        ->get()
                        ->mapWithKeys(fn ($dealer) => [
                            $dealer->id => $dealer->user->name,
                        ])
                )
                ->columns(2),
        ];
    }

}
