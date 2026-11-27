<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockInItem extends Model
{
    protected $fillable = ['stock_in_id', 'part_id', 'quantity', 'unit_cost', 'subtotal'];

    protected function casts(): array
    {
        return [
            'unit_cost' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (StockInItem $item) {
            $item->subtotal = ((float) $item->unit_cost) * ((int) $item->quantity);
        });

        static::created(function (StockInItem $item) {
            if ($item->part) {
                $item->part->increment('stock_quantity', $item->quantity);
                $item->part->update(['cost_price' => $item->unit_cost]);
            }
            if ($item->stockIn) {
                $item->stockIn->update([
                    'total_cost' => $item->stockIn->items()->sum('subtotal'),
                ]);
            }
        });
    }

    public function stockIn(): BelongsTo
    {
        return $this->belongsTo(StockIn::class);
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }
}