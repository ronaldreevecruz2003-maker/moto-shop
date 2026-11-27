<?php

namespace App\Filament\Widgets;

use App\Models\Part;
use App\Models\RepairBooking;
use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class ShopStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $todaySales = Sale::whereDate('created_at', today())->sum('total_amount');
        $todayCount = Sale::whereDate('created_at', today())->count();

        $inventoryCost = Part::sum(DB::raw('cost_price * stock_quantity'));
        $inventoryRetail = Part::sum(DB::raw('price * stock_quantity'));
        $lowStockCount = Part::whereColumn('stock_quantity', '<=', 'reorder_level')->count();
        $pendingBookings = RepairBooking::where('status', 'pending')->count();

        return [
            Stat::make("Today's Sales ({$todayCount} orders)", '₱' . number_format($todaySales, 2))
                ->description('Walk-in POS & Online Orders')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Inventory Retail Value', '₱' . number_format($inventoryRetail, 2))
                ->description('Cost Value: ₱' . number_format($inventoryCost, 2))
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('primary'),

            Stat::make('Low Stock Alerts', (string) $lowStockCount)
                ->description($lowStockCount > 0 ? 'Parts at or below reorder level' : 'All stock levels healthy')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($lowStockCount > 0 ? 'danger' : 'success'),

            Stat::make('Pending Repairs', (string) $pendingBookings)
                ->description('Awaiting mechanic schedule')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color($pendingBookings > 0 ? 'warning' : 'success'),
        ];
    }
}