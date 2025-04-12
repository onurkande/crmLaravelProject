<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $fillable = ['user_id', 'desired_role'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDisplayRoleAttribute()
    {
        return match($this->desired_role) {
            'admin' => 'Admin',
            'sales_consultant' => 'Satış Danışmanı',
            'agency' => 'Acente',
            default => $this->desired_role,
        };
    }
} 