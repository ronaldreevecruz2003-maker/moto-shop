<?php

namespace App\Filament\Resources\StockIns;

use App\Filament\Resources\StockIns\Pages;
use App\Models\Part;
use App\Models\StockIn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class StockInResource extends Resource
{
    protected static ?string $model = StockIn::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-archive-box-arrow-down';
    protected static ?string $navigationLabel = 'Stock-In Receiving';
    protected static string | \UnitEnum | null $navigationGroup = 'Inventory Control';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Delivery Details')->columns(3)->schema([
                TextInput::make('reference_no')
                    ->default(fn () => 'SI-' . now()->format('Ymd-His'))
                    ->required()
                    ->unique(ignoreRecord: true),
                Select::make('supplier_id')
                    ->relationship('supplier', 'name')
                    ->searchable()
                    ->preload(),
                DatePicker::make('received_date')
                    ->default(now())
                    ->required(),
                Textarea::make('notes')->columnSpanFull(),
            ]),
            Section::make('Received Parts')->schema([
                Repeater::make('items')
                    ->relationship()
                    ->minItems(1)
                    ->columns(4)
                    ->schema([
                        Select::make('part_id')
                            ->label('Part')
                            ->options(Part::query()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $part = Part::find($state);
                                $cost = $part?->cost_price ?? 0;
                                $qty = (int) ($get('quantity') ?: 1);
                                $set('unit_cost', $cost);
                                $set('subtotal', $cost * $qty);
                            })
                            ->columnSpan(2),
                        TextInput::make('quantity')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($state, Set $set, Get $get) => $set('subtotal', ((float) $get('unit_cost')) * ((int) $state))),
                        TextInput::make('unit_cost')
                            ->numeric()
                            ->prefix('₱')
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($state, Set $set, Get $get) => $set('subtotal', ((float) $state) * ((int) $get('quantity')))),
                        Hidden::make('subtotal')->default(0),
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('reference_no')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('supplier.name')->placeholder('Direct / Walk-In'),
                Tables\Columns\TextColumn::make('received_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('total_cost')->money('PHP')->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Received By'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockIns::route('/'),
            'create' => Pages\CreateStockIn::route('/create'),
        ];
    }
}