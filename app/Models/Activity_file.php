<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity_file extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity',
        'farming_data_id',
        'farmer_id',
        'status',
        'date',
    ];
}
