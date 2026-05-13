<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $fillable = ['vin', 'make', 'model', 'year', 'engine'];

    /**
     * Get the parts for the vehicle.
     */
    public function parts(): HasMany
    {
        return $this->hasMany(Part::class);
    }
}