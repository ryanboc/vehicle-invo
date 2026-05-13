<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Table('vehicles')]
class Vehicle extends Model
{
    #[Fillable(['brand', 'model', 'year', 'color'])]
    protected $fillable = [];
}
