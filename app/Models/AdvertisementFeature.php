<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementFeature extends Model
{
    protected $fillable = [
        'advertisement_id', 'supermarket', 'spa_sauna_massage',
        'exchange_office', 'cafe_bar', 'gift_shop', 'pharmacy',
        'bank', 'bicycle_path', 'green_areas', 'restaurant',
        'playground', 'water_slides', 'walking_track', 'fitness_gym',
        'football_field', 'pool', 'security', 'parking', 'ev_charging'
    ];

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
} 