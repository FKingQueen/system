<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'municipality',
        'municipality_id',
        'status',
        'barangay',
        'barangay',
    ];

    public function municipality()
    {
        return $this->hasOne(Municipality::class, 'id', 'municipality_id');
    }

    public function barangays()
    {
        return $this->hasOne(Barangay::class, 'id', 'barangay_id');
    }

    public function farming_datas()
    {
        return $this->hasMany(Farming_data::class);
    }
}
