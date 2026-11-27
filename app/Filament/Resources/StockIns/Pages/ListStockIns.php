<?php
namespace App\Filament\Resources\StockIns\Pages;
use App\Filament\Resources\StockIns\StockInResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListStockIns extends ListRecords { protected static string $resource = StockInResource::class; protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; } }