<?php

namespace App\Filament\Stores\Resources\DealerResource\Pages;

use App\Filament\Stores\Resources\DealerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDealers extends ListRecords
{
    protected static string $resource = DealerResource::class;

    protected static ?string $breadcrumb = 'Todos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
