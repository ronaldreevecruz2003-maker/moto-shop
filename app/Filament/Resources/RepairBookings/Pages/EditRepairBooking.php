<?php

namespace App\Filament\Resources\RepairBookings\Pages;

use App\Filament\Resources\RepairBookings\RepairBookingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRepairBooking extends EditRecord
{
    protected static string $resource = RepairBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
