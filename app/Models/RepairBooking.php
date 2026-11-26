<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepairBooking extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'motorcycle_model_id',
        'custom_motorcycle',
        'plate_number',
        'service_id',
        'scheduled_at',
        'status',
        'mechanic_notes',
        'total_amount',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function motorcycleModel(): BelongsTo
    {
        return $this->belongsTo(MotorcycleModel::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
