<?php

namespace App\Filament\Resources\MotorcycleModels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MotorcycleModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('brand')
                    ->required(),
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
