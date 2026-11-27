<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockIn extends Model
{
    protected $fillable = ['reference_no', 'supplier_id', 'user_id', 'received_date', 'total_cost', 'notes'];

    protected function casts(): array
    {
        return [
            'received_date' => 'date',
            'total_cost' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (StockIn $stockIn) {
            if (empty($stockIn->user_id) && auth()->check()) {
                $stockIn->user_id = auth()->id();
            }
        });
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(StockInItem::class);
    }
}