<?php

namespace App\Filament\Stores\Resources\RunResource\Pages;

use App\Filament\Stores\Resources\RunResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRun extends EditRecord
{
    protected static string $resource = RunResource::class;

    protected static ?string $breadcrumb = 'Editar';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
