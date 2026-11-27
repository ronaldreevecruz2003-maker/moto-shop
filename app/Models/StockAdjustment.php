<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockAdjustment extends Model
{
    protected $fillable = ['part_id', 'user_id', 'reason', 'quantity_deducted', 'previous_stock', 'new_stock', 'remarks'];

    protected static function booted(): void
    {
        static::creating(function (StockAdjustment $adj) {
            if (empty($adj->user_id) && auth()->check()) {
                $adj->user_id = auth()->id();
            }
            $part = Part::find($adj->part_id);
            if ($part) {
                $adj->previous_stock = $part->stock_quantity;
                $adj->new_stock = max(0, $part->stock_quantity - abs((int) $adj->quantity_deducted));
            }
        });

        static::created(function (StockAdjustment $adj) {
            $adj->part?->update(['stock_quantity' => $adj->new_stock]);
        });
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}