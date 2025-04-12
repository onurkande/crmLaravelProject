<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable = [
        'name', 'price', 'description', 'deposit_status',
        'sale_status', 'reserve_status', 'cover_image',
        'cover_image_thumb', 'debt_amount', 'square_meters',
        'apartment_number', 'room_type', 'city', 'map_location',
        'created_by', 'commission'
    ];

    public function images()
    {
        return $this->hasMany(AdvertisementImage::class);
    }

    public function features()
    {
        return $this->hasOne(AdvertisementFeature::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // **Fiyatı formatlayan Accessor**
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.') . ' £';
    }

    // Resim erişim metodları
    public function getCoverImageLargeAttribute()
    {
        return $this->cover_image;
    }

    public function getCoverImageThumbAttribute()
    {
        return str_replace('_large.webp', '_thumb.webp', $this->cover_image);
    }
} 