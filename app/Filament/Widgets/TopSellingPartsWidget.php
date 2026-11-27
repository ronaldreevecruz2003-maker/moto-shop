<?php

namespace App\Filament\Widgets;

use App\Models\Part;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopSellingPartsWidget extends BaseWidget
{
    protected static ?string $heading = 'Top-Selling Motorcycle Parts';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Part::query()
                    ->withSum('saleItems as total_sold', 'quantity')
                    ->withSum('saleItems as total_revenue', 'subtotal')
                    ->orderByDesc('total_sold')
            )
            ->columns([
                Tables\Columns\TextColumn::make('sku')->label('SKU')->weight('bold'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('category.name')->label('Category')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('total_sold')
                    ->label('Units Sold')
                    ->default(0)
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('total_revenue')
                    ->label('Total Revenue')
                    ->money('PHP')
                    ->default(0),
                Tables\Columns\TextColumn::make('stock_quantity')->label('Current Stock'),
            ])
            ->paginated([5]);
    }
}