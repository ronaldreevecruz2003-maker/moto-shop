<?php

namespace App\Filament\Widgets;

use App\Models\Part;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockPartsWidget extends BaseWidget
{
    protected static ?string $heading = 'Low Stock Parts (Restock Needed)';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Part::query()
                    ->where('is_active', true)
                    ->where('stock_quantity', '<=', 5)
                    ->orderBy('stock_quantity', 'asc')
            )
            ->columns([
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Part Name')
                    ->description(fn (Part $record): string => $record->brand ?? ''),
                TextColumn::make('category.name')
                    ->badge()
                    ->color('success'),
                TextColumn::make('price')
                    ->label('Price')
                    ->money('PHP'),
                TextInputColumn::make('stock_quantity')
                    ->label('Update Stock')
                    ->rules(['required', 'integer', 'min:0']),
            ])
            ->emptyStateHeading('All parts are well-stocked!')
            ->emptyStateDescription('Walang piyesa na 5 piraso o mas mababa ang stock.');
    }
}
