<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MotorcycleModel extends Model
{
    protected $fillable = ['brand', 'name'];

    public function parts(): BelongsToMany
    {
        return $this->belongsToMany(Part::class);
    }
}
