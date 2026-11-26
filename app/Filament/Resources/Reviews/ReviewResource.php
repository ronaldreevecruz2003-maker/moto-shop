<?php

namespace App\Filament\Resources\Reviews;

use App\Filament\Resources\Reviews\Pages\ManageReviews;
use App\Models\Review;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('customer_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('motorcycle_model')
                    ->placeholder('e.g., Yamaha NMAX 155')
                    ->maxLength(255),
                Select::make('type')
                    ->options([
                        'mechanic' => 'Mechanic & Service Bay',
                        'product' => 'Part / Product',
                    ])
                    ->required(),
                Select::make('part_id')
                    ->relationship('part', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Select::make('rating')
                    ->options([
                        5 => '5 Stars - Excellent',
                        4 => '4 Stars - Good',
                        3 => '3 Stars - Average',
                        2 => '2 Stars - Fair',
                        1 => '1 Star - Poor',
                    ])
                    ->default(5)
                    ->required(),
                Textarea::make('comment')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                Toggle::make('is_approved')
                    ->label('Visible on Storefront')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_name')
                    ->searchable()
                    ->description(fn (Review $record): string => $record->motorcycle_model ?? ''),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'mechanic' ? 'success' : 'danger')
                    ->formatStateUsing(fn (string $state): string => $state === 'mechanic' ? 'Mechanic' : 'Product'),
                TextColumn::make('part.name')
                    ->label('Reviewed Part')
                    ->placeholder('Service Bay'),
                TextColumn::make('rating')
                    ->formatStateUsing(fn (int $state): string => str_repeat('?', $state))
                    ->color('warning'),
                TextColumn::make('comment')
                    ->limit(50),
                ToggleColumn::make('is_approved')
                    ->label('Approved'),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
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
            'index' => ManageReviews::route('/'),
        ];
    }
}
