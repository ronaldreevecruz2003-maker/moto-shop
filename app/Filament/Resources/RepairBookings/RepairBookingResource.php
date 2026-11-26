<?php

namespace App\Filament\Resources\RepairBookings;

use App\Filament\Resources\RepairBookings\Pages\CreateRepairBooking;
use App\Filament\Resources\RepairBookings\Pages\EditRepairBooking;
use App\Filament\Resources\RepairBookings\Pages\ListRepairBookings;
use App\Models\RepairBooking;
use App\Models\Service;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RepairBookingResource extends Resource
{
    protected static ?string $model = RepairBooking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Customer & Motorcycle Info')
                    ->columns(2)
                    ->schema([
                        TextInput::make('customer_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('customer_phone')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('custom_motorcycle')
                            ->label('Motorcycle Brand & Model')
                            ->placeholder('e.g., Yamaha NMAX 155, Honda Beat')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('plate_number')
                            ->placeholder('e.g., 123-ABC'),
                    ]),
                Section::make('Service & Schedule')
                    ->columns(2)
                    ->schema([
                        Select::make('service_id')
                            ->relationship('service', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
                                $service = Service::find($state);
                                if ($service) {
                                    $set('total_amount', $service->labor_price);
                                }
                            }),
                        DateTimePicker::make('scheduled_at')
                            ->required()
                            ->default(now()),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'in_progress' => 'In Progress (Ginigawa)',
                                'completed' => 'Completed (Tapos na)',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('pending')
                            ->required(),
                        TextInput::make('total_amount')
                            ->label('Total Labor/Bill (?)')
                            ->numeric()
                            ->prefix('?')
                            ->required(),
                        Textarea::make('mechanic_notes')
                            ->label('Mechanic Notes / Parts Used')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('scheduled_at')
                    ->label('Schedule')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
                TextColumn::make('customer_name')
                    ->searchable()
                    ->description(fn (RepairBooking $record): string => $record->customer_phone),
                TextColumn::make('custom_motorcycle')
                    ->label('Motor')
                    ->searchable()
                    ->formatStateUsing(fn ($record) => $record->custom_motorcycle ?: ($record->motorcycleModel ? "{$record->motorcycleModel->brand} {$record->motorcycleModel->name}" : '-'))
                    ->description(fn (RepairBooking $record): string => $record->plate_number ?? ''),
                TextColumn::make('service.name')
                    ->badge()
                    ->color('info'),
                SelectColumn::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                TextColumn::make('total_amount')
                    ->label('Bill')
                    ->money('PHP')
                    ->sortable(),
            ])
            ->defaultSort('scheduled_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
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
            'index' => ListRepairBookings::route('/'),
            'create' => CreateRepairBooking::route('/create'),
            'edit' => EditRepairBooking::route('/{record}/edit'),
        ];
    }
}
