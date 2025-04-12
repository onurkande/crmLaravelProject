<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = [
        'price',
        'consultant_id',
        'percentage',
        'commission_amount',
        'calculated_by'
    ];

    public function consultant()
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }

    public function calculator()
    {
        return $this->belongsTo(User::class, 'calculated_by');
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.') . ' £';
    }

    public function getFormattedCommissionAmountAttribute()
    {
        return number_format($this->commission_amount, 0, ',', '.') . ' £';
    }
} 