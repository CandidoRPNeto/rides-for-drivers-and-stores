<?php

namespace App\Filament\Stores\Resources;

use App\Filament\Stores\Resources\RunResource\Pages;
use App\Filament\Stores\Resources\RunResource\RelationManagers;
use App\Models\Delivery;
use App\Models\Run;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RunResource extends Resource
{
    protected static ?string $model = Run::class;

    protected static ?string $navigationIcon = 'eos-delivery-dining-o';

    protected static ?string $label = 'Entrega';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('dealer_id')
                ->columnSpan(2)
                ->label('Entregador')
                ->placeholder('Escolha alguem para fazer a entrega')
                ->required()
                ->relationship(
                    name: 'dealer',
                    titleAttribute: 'users.name',
                    modifyQueryUsing: function (Builder $query) {
                        if (request()->routeIs('filament.pages.list-runs')) {
                            return $query->join('users', 'dealers.user_id', '=', 'users.id')->where('status', 1);
                        }
                        return $query->join('users', 'dealers.user_id', '=', 'users.id');
                    }
                ),
                Select::make('deliveries')
                ->columnSpan(2)
                ->label('Entregas')
                ->multiple()
                ->required()
                ->placeholder('Selecione os pedidos para a entrega')
                ->relationship(
                    name: 'deliveries',
                    titleAttribute: 'name',
                    modifyQueryUsing: function (Builder $query) {
                        if (request()->routeIs('filament.pages.list-runs')) {
                            return $query->where('status', 1);
                        }
                        return $query;
                    }
                )
                ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('5s')
            ->columns([
                TextColumn::make('dealer.user.name')->label('Entregador'),
                TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->getStateUsing(fn ($record) => match ((int)$record->status) {
                    1 => 'Entrega Criada',
                    2 => 'Em Andamento',
                    3 => 'Concluída'
                })
                ->color(fn ($state) => match ($state) {
                    'Entrega Criada' => 'gray',
                    'Em Andamento' => 'warning',
                    'Concluída' => 'success'
                }),
                TextColumn::make('started_at')
                ->label('Duração')
                ->getStateUsing(fn ($record) => match (true) {
                    is_null($record->started_at) => '--:--',
                    is_null($record->finished_at) => Carbon::parse($record->started_at)->diff(Carbon::now())->format('%H:%I'),
                    default => Carbon::parse($record->started_at)->diff(Carbon::parse($record->finished_at))->format('%H:%I')
                }),
            ])
            ->paginated([5, 10, 20, 50])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                ->label('Status')
                ->options([
                    1 => 'Entrega Criada',
                    2 => 'Em Andamento',
                    3 => 'Concluída'
                ])
                ->default(1),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListRuns::route('/'),
            'create' => Pages\CreateRun::route('/create'),
        ];
    }
}
