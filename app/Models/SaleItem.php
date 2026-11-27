<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'part_id',
        'quantity',
        'cost_price',
        'unit_price',
        'subtotal',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function getSellingPriceAttribute()
    {
        return $this->unit_price;
    }

    protected static function booted(): void
    {
        static::created(function (SaleItem $item) {
            $item->part?->decrement('stock_quantity', $item->quantity);
        });

        static::deleted(function (SaleItem $item) {
            $item->part?->increment('stock_quantity', $item->quantity);
        });
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }
}