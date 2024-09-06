<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipments extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_type_id',
        'name',
        'price',
        'amount',
        'user_id',
    ];

    protected $casts = [
        'name' => 'array'
    ];
}
