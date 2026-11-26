<?php

namespace App\Filament\Resources\RepairBookings\Pages;

use App\Filament\Resources\RepairBookings\RepairBookingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRepairBookings extends ListRecords
{
    protected static string $resource = RepairBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
