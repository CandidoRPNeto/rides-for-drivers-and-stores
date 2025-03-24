<?php

namespace App\Filament\Stores\Resources\DeliveryResource\Pages;

use App\Filament\Stores\Resources\DeliveryResource;
use App\Models\Delivery;
use App\Models\Location;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDelivery extends CreateRecord
{
    protected static string $resource = DeliveryResource::class;

    protected static ?string $breadcrumb = 'Criar';


    protected function handleRecordCreation(array $data): Delivery
    {
        $data = $this->data;
        $location  = Location::create([
            'address' => $data['location']['address'],
            'reference' => $data['location']['reference'],
            'latitude' => 1.2,
            'longitude' => 1.2
        ]);
        return Delivery::create([
            'location_id' => $location->id,
            'name' => $data['name'],
            'phone' => $data['phone']
        ]);
    }
}
