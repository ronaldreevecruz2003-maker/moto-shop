<?php

namespace App\Filament\Resources\Parts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PartsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('sku')
                    ->label('SKU')
                    ->weight('bold')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->badge()
                    ->color('gray')
                    ->searchable(),
                TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('cost_price')
                    ->label('Cost')
                    ->money('PHP')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('price')
                    ->label('Selling Price')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn ($record) => $record->stock_quantity <= 0
                        ? 'danger'
                        : ($record->stock_quantity <= ($record->reorder_level ?? 5) ? 'warning' : 'success')),
                TextColumn::make('rack_location')
                    ->label('Rack')
                    ->placeholder('—')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}