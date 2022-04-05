<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farming_data extends Model
{
    protected $fillable = [
        'crop_id',
        'cropping_season_id',
        'status_id',
        'farmer_id',
        'lot_size',
        'yield',
        'sacks',
        'kg',
        'unit',
    ];

    public function crop()
    {
        return $this->hasOne(Crop::class, 'id', 'crop_id');
    }

    public function cropping_season()
    {
        return $this->hasOne(Cropping_season::class, 'id', 'cropping_season_id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

}
