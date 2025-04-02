<?php

namespace App\Filament\Stores\Resources;

use App\Filament\Stores\Resources\DeliveryResource\Pages;
use App\Filament\Stores\Resources\DeliveryResource\RelationManagers;
use App\Models\Delivery;
use App\Models\Run;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class DeliveryResource extends Resource
{
    protected static ?string $model = Delivery::class;

    protected static ?string $navigationIcon = 'phosphor-package';

    protected static ?string $label = 'Pedido';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações Básicas')
                ->schema([
                    Forms\Components\Grid::make(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Pedido')
                            ->columnSpan(1),
                        TextInput::make('phone')
                        ->label('Contato')
                        ->columnSpan(1)
                        ->dehydrateStateUsing(fn ($state) => preg_replace('/\D/', '', $state))
                        ->mask('(99) 99999-9999'),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                1 => 'Novo',
                                2 => 'Preparado',
                                3 => 'A Caminho',
                                4 => 'Entregue',
                                5 => 'Cancelado'
                            ])
                            ->hidden(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                            ->columnSpan(2),
                    ])
                ]),
                Forms\Components\Section::make('Endereço')
                ->relationship('location')
                ->schema([
                    Forms\Components\TextInput::make('address')->label('Endereço'),
                    Forms\Components\TextInput::make('reference')->label('Referencia'),
                ]),
                Forms\Components\Section::make('Avaliação')
                ->relationship('rating')
                ->hidden(fn ($record) => is_null($record?->rating))
                ->schema([
                    Forms\Components\Select::make('score')
                    ->label('Nota')
                    ->options([
                        1 => '1 - Ruim',
                        2 => '2 - Regular',
                        3 => '3 - Bom',
                        4 => '4 - Muito Bom',
                        5 => '5 - Excelente',
                    ])
                    ->disabled()
                    ->suffixIcon('heroicon-o-star'),
                    Forms\Components\Textarea::make('description')->label('Avaliação')->disabled(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('10s')
            ->defaultSort('created_at', 'asc')
            ->columns([
                TextColumn::make('name')->label('Pedido'),
                TextColumn::make('phone')
                ->label('Contato')
                ->copyable()
                ->formatStateUsing(fn ($state) => preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $state)),
                TextColumn::make('location.address')->label('Endereço'),
                TextColumn::make('rating.score')
                ->label('Avaliação')
                ->icon('fas-star')
                ->getStateUsing(fn ($record) => match (true) {
                    is_null($record->rating) => '-',
                    default => $record->rating->score
                })
                ->color(fn (string $state): string => match ($state) {
                    '-' => 'gray',
                    default => 'warning'
                }),
                TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->getStateUsing(fn ($record) => match ($record->status) {
                    1 => 'Novo',
                    2 => 'Preparado',
                    3 => 'A Caminho',
                    4 => 'Entregue',
                    5 => 'Cancelado'
                })
                ->color(fn ($state) => match ($state) {
                    'Novo' => 'danger',
                    'Preparado' => 'success',
                    'A Caminho' => 'warning',
                    'Entregue' => 'success',
                    'Cancelado' => 'gray'
                }),
            ])
            ->paginated([5, 10, 20, 50])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                ->label('Status')
                ->options([
                    1 => 'Novo',
                    2 => 'Preparado',
                    3 => 'A Caminho',
                    4 => 'Entregue',
                    5 => 'Cancelado'
                ])
                ->default(1),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('criar_run')
                ->label('Criar Entrega')
                ->icon('eos-delivery-dining-o')
                ->color('primary')
                ->modalHeading('Criar Nova Corrida')
                ->form([
                    Select::make('dealer_id')
                    ->columnSpan(2)
                    ->label('Entregador')
                    ->placeholder('Escolha alguem para fazer a entrega')
                    ->required()
                    ->relationship(
                        name: 'run.dealer',
                        titleAttribute: 'users.name',
                        modifyQueryUsing: fn (Builder $query) => $query->join('users', 'dealers.user_id', '=', 'users.id')
                    ),
                ])
                ->action(fn ($records, array $data) => static::createRun($records, $data)),
                Tables\Actions\DeleteBulkAction::make()
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
            'index' => Pages\ListDeliveries::route('/'),
            'create' => Pages\CreateDelivery::route('/create'),
        ];
    }

    public static function createRun( $records, array $data)
    {
        $run = Run::create([ 'dealer_id' => $data['dealer_id'] ]);
        foreach ($records as $delivery) {
            $delivery->update([ 'run_id' => $run->id, 'status' => 2 ]);
        }
        Notification::make()->title('Corrida criada com sucesso!')->success()->send();
    }
}
