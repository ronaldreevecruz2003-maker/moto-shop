<?php

namespace App\Filament\Resources\StockAdjustments;

use App\Filament\Resources\StockAdjustments\Pages;
use App\Models\Part;
use App\Models\StockAdjustment;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class StockAdjustmentResource extends Resource
{
    protected static ?string $model = StockAdjustment::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-exclamation-triangle';
    protected static ?string $navigationLabel = 'Stock Adjustments';
    protected static string | \UnitEnum | null $navigationGroup = 'Inventory Control';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Stock Deduction Audit')->columns(2)->schema([
                Select::make('part_id')
                    ->label('Part')
                    ->options(Part::query()->where('stock_quantity', '>', 0)->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->live(),
                Select::make('reason')
                    ->options([
                        'Damaged' => 'Damaged',
                        'Lost' => 'Lost',
                        'Expired' => 'Expired',
                        'Inventory Count Correction' => 'Inventory Count Correction',
                    ])
                    ->required(),
                TextInput::make('quantity_deducted')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(fn (Get $get) => Part::find($get('part_id'))?->stock_quantity ?? 1)
                    ->required()
                    ->helperText(fn (Get $get) => ($p = Part::find($get('part_id'))) ? "Current stock: {$p->stock_quantity}" : 'Select a part first'),
                Textarea::make('remarks')
                    ->required()
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Date')->dateTime('M d, Y h:i A')->sortable(),
                Tables\Columns\TextColumn::make('part.sku')->label('SKU')->searchable(),
                Tables\Columns\TextColumn::make('part.name')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('reason')->badge()->color('danger'),
                Tables\Columns\TextColumn::make('quantity_deducted')->label('Deducted')->color('danger'),
                Tables\Columns\TextColumn::make('previous_stock')->label('Before'),
                Tables\Columns\TextColumn::make('new_stock')->label('After')->weight('bold'),
                Tables\Columns\TextColumn::make('user.name')->label('Logged By'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockAdjustments::route('/'),
            'create' => Pages\CreateStockAdjustment::route('/create'),
        ];
    }
}