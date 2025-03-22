<?php

namespace App\Filament\Stores\Resources\DeliveryResource\Pages;

use App\Filament\Stores\Resources\DeliveryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeliveries extends ListRecords
{
    protected static string $resource = DeliveryResource::class;

    protected static ?string $breadcrumb = 'Todos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
