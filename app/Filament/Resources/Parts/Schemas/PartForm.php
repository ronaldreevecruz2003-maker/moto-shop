<?php

namespace App\Filament\Resources\Parts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PartForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Part Identification')->columns(2)->schema([
                    Select::make('category_id')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('supplier_id')
                        ->relationship('supplier', 'name')
                        ->searchable()
                        ->preload()
                        ->nullable(),
                    TextInput::make('sku')
                        ->label('SKU')
                        ->required()
                        ->unique(ignoreRecord: true),
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('brand')
                        ->default(null),
                    TextInput::make('rack_location')
                        ->label('Rack / Bin Location')
                        ->placeholder('e.g. A1-04'),
                    Select::make('compatibleModels')
                        ->label('Compatible Motorcycles')
                        ->relationship('compatibleModels', 'name')
                        ->multiple()
                        ->preload()
                        ->columnSpanFull(),
                    Textarea::make('description')
                        ->default(null)
                        ->columnSpanFull(),
                ]),
                Section::make('Pricing & Stock Control')->columns(3)->schema([
                    TextInput::make('cost_price')
                        ->label('Cost Price (Puhunan)')
                        ->numeric()
                        ->default(0)
                        ->prefix('₱'),
                    TextInput::make('price')
                        ->label('Selling Price')
                        ->required()
                        ->numeric()
                        ->prefix('₱'),
                    TextInput::make('stock_quantity')
                        ->label('Current Stock')
                        ->required()
                        ->numeric()
                        ->default(0),
                    TextInput::make('reorder_level')
                        ->label('Reorder Alert Level')
                        ->required()
                        ->numeric()
                        ->default(5),
                    FileUpload::make('image')
                        ->image(),
                    Toggle::make('is_active')
                        ->default(true)
                        ->required(),
                ]),
            ]);
    }
}