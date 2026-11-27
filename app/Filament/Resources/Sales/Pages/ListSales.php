<?php

namespace App\Filament\Resources\Sales\Pages;

use App\Filament\Resources\Sales\SaleResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSales extends ListRecords
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('open_pos')
                ->label('Open POS Terminal')
                ->icon('heroicon-o-calculator')
                ->color('success')
                ->url(route('pos.index')),
            CreateAction::make(),
        ];
    }
}