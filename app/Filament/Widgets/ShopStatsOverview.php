<?php

namespace App\Filament\Widgets;

use App\Models\Part;
use App\Models\RepairBooking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ShopStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalParts = Part::where('is_active', true)->count();
        $lowStockCount = Part::where('is_active', true)->where('stock_quantity', '<=', 5)->count();
        $activeRepairs = RepairBooking::whereIn('status', ['pending', 'in_progress'])->count();
        $completedRevenue = RepairBooking::where('status', 'completed')->sum('total_amount');

        return [
            Stat::make('Active Parts in Catalog', $totalParts)
                ->description('Available items in Balaoan Cycle Parts')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('success'),

            Stat::make('Low Stock Alert (= 5 pcs)', $lowStockCount)
                ->description($lowStockCount > 0 ? 'Needs restocking soon' : 'All stocks healthy')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($lowStockCount > 0 ? 'danger' : 'success'),

            Stat::make('Active Repair Bay Queue', $activeRepairs)
                ->description('Pending & In-Progress motorcycles')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('warning'),

            Stat::make('Completed Repair Income', '?' . number_format($completedRevenue, 2))
                ->description('Total labor collected from completed jobs')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
