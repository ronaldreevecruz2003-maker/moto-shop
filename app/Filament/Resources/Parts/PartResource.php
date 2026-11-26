<?php

namespace App\Filament\Resources\Parts;

use App\Filament\Resources\Parts\Pages\CreatePart;
use App\Filament\Resources\Parts\Pages\EditPart;
use App\Filament\Resources\Parts\Pages\ListParts;
use App\Models\Part;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PartResource extends Resource
{
    protected static ?string $model = Part::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Part Details')
                    ->columns(2)
                    ->schema([
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')->required(),
                                TextInput::make('slug')->required(),
                            ]),
                        TextInput::make('sku')
                            ->label('SKU / Part Code')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('name')
                            ->label('Part Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('brand')
                            ->placeholder('e.g., JVT, RCB, Pirelli, Yamaha Genuine')
                            ->maxLength(255),
                        TextInput::make('price')
                            ->numeric()
                            ->prefix('?')
                            ->required(),
                        TextInput::make('stock_quantity')
                            ->label('Stock on Hand')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Select::make('compatibleModels')
                            ->label('Compatible Motorcycles')
                            ->relationship('compatibleModels', 'name')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->brand} {$record->name}")
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                Section::make('Media & Visibility')
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->directory('parts')
                            ->disk('public')
                            ->imageEditor(),
                        Toggle::make('is_active')
                            ->label('Show in Storefront')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->square(),
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Part $record): string => $record->brand ?? ''),
                TextColumn::make('category.name')
                    ->badge()
                    ->sortable(),
                TextInputColumn::make('price')
                    ->label('Price (?)')
                    ->rules(['required', 'numeric', 'min:0'])
                    ->sortable(),
                TextInputColumn::make('stock_quantity')
                    ->label('Stock')
                    ->rules(['required', 'integer', 'min:0'])
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name'),
            ])
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
            'index' => ListParts::route('/'),
            'create' => CreatePart::route('/create'),
            'edit' => EditPart::route('/{record}/edit'),
        ];
    }
}
