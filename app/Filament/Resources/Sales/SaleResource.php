<?php

namespace App\Filament\Resources\Sales;

use App\Filament\Resources\Sales\Pages\CreateSale;
use App\Filament\Resources\Sales\Pages\EditSale;
use App\Filament\Resources\Sales\Pages\ListSales;
use App\Models\Part;
use App\Models\Sale;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationLabel = 'Walk-In Sales (POS)';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Receipt & Customer Info')
                    ->columns(3)
                    ->schema([
                        TextInput::make('invoice_number')
                            ->label('Receipt / Invoice #')
                            ->default(fn () => 'BCP-' . now()->format('Ymd-His'))
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('customer_name')
                            ->default('Walk-in Customer')
                            ->required(),
                        Select::make('payment_method')
                            ->options([
                                'cash' => 'Cash',
                                'gcash' => 'GCash',
                                'maya' => 'Maya / Bank Transfer',
                            ])
                            ->default('cash')
                            ->required(),
                    ]),

                Section::make('Parts Purchased')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->columns(4)
                            ->defaultItems(1)
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::updateTotals($get, $set);
                            })
                            ->schema([
                                Select::make('part_id')
                                    ->label('Part / Item')
                                    ->options(fn () => Part::where('is_active', true)
                                        ->get()
                                        ->mapWithKeys(fn ($part) => [
                                            $part->id => "{$part->name} (?" . number_format($part->price, 2) . " | Stock: {$part->stock_quantity})"
                                        ]))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        $part = Part::find($state);
                                        if ($part) {
                                            $qty = (int) ($get('quantity') ?: 1);
                                            $set('unit_price', $part->price);
                                            $set('subtotal', $part->price * $qty);
                                        }
                                    })
                                    ->columnSpan(2),

                                TextInput::make('quantity')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        $price = (float) ($get('unit_price') ?: 0);
                                        $set('subtotal', $price * (int) $state);
                                    }),

                                TextInput::make('unit_price')
                                    ->label('Unit Price (?)')
                                    ->numeric()
                                    ->prefix('?')
                                    ->required()
                                    ->readOnly(),

                                TextInput::make('subtotal')
                                    ->label('Subtotal (?)')
                                    ->numeric()
                                    ->prefix('?')
                                    ->required()
                                    ->readOnly()
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Section::make('Summary')
                    ->columns(2)
                    ->schema([
                        TextInput::make('total_amount')
                            ->label('Grand Total (?)')
                            ->numeric()
                            ->prefix('?')
                            ->default(0)
                            ->required()
                            ->readOnly(),
                        Textarea::make('notes')
                            ->rows(2),
                    ]),
            ]);
    }

    public static function updateTotals(Get $get, Set $set): void
    {
        $items = $get('items') ?? [];
        $total = 0;
        foreach ($items as $item) {
            $total += (float) ($item['subtotal'] ?? 0);
        }
        $set('total_amount', number_format($total, 2, '.', ''));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
                TextColumn::make('invoice_number')
                    ->label('Invoice #')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('customer_name')
                    ->searchable(),
                TextColumn::make('payment_method')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn (string $state): string => strtoupper($state)),
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('PHP')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                Action::make('receipt')
                    ->label('Receipt')
                    ->icon(Heroicon::OutlinedPrinter)
                    ->color('success')
                    ->url(fn (Sale $record): string => route('sales.receipt', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSales::route('/'),
            'create' => CreateSale::route('/create'),
            'edit' => EditSale::route('/{record}/edit'),
        ];
    }
}
