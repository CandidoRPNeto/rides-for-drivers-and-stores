<?php

namespace App\Filament\Stores\Resources\DealerResource\Pages;

use App\Filament\Stores\Resources\DealerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDealer extends CreateRecord
{
    protected static string $resource = DealerResource::class;

    protected static ?string $breadcrumb = 'Criar';
}
