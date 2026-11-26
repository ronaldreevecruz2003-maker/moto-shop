<?php

namespace App\Filament\Resources\RepairBookings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RepairBookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('customer_name')
                    ->required(),
                TextInput::make('customer_phone')
                    ->tel()
                    ->required(),
                Select::make('motorcycle_model_id')
                    ->relationship('motorcycleModel', 'name')
                    ->default(null),
                TextInput::make('plate_number')
                    ->default(null),
                Select::make('service_id')
                    ->relationship('service', 'name')
                    ->required(),
                DateTimePicker::make('scheduled_at')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
            ]);
    }
}
