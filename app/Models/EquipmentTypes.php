<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentTypes extends Model
{
    use HasFactory;

    protected $fillable = [
        'th_name',
        'en_name',
    ];
}
