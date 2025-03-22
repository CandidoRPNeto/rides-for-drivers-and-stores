<?php

namespace App\Filament\Stores\Resources\DeliveryResource\Pages;

use App\Filament\Stores\Resources\DeliveryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDelivery extends CreateRecord
{
    protected static string $resource = DeliveryResource::class;

    protected static ?string $breadcrumb = 'Criar';
}
