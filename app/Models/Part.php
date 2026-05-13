<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    // Adding 'part_number' here allows the store() method to save it
    protected $fillable = [
        'vehicle_id', 
        'name', 
        'part_number', 
        'quantity', 
        'price'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}