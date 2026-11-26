<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('labor_price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('estimated_minutes')
                    ->required()
                    ->numeric()
                    ->default(30),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
