<?php

namespace App\Filament\Stores\Resources\RunResource\Pages;

use App\Filament\Stores\Resources\RunResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRuns extends ListRecords
{
    protected static string $resource = RunResource::class;

    protected static ?string $breadcrumb = 'Todos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Nova Entrega'),
        ];
    }
}
