<?php

namespace App\Filament\Stores\Resources\RunResource\Pages;

use App\Filament\Stores\Resources\RunResource;
use App\Models\Delivery;
use App\Models\Run;
use App\Models\Location;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateRun extends CreateRecord
{
    protected static string $resource = RunResource::class;

    protected static ?string $breadcrumb = 'Criar';


    protected function handleRecordCreation(array $data): Run
    {
        $data = $this->data;
        return DB::transaction(function () use ($data) {
            $run = Run::create(["dealer_id" => $data['dealer_id']]);
            $run->dealer->update(['status' => 2]);
            Delivery::whereIn('id', $data['deliveries'])->update(['run_id' => $run->id, 'status' => 2]);
            return $run;
        });
    }
}
