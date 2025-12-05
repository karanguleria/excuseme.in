<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = [
        'restaurant_id',
        'table_number',
        'qr_code',
        'unique_url',
        'is_ringing'
    ];

    protected $casts = [
        'is_ringing' => 'boolean',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function calls()
    {
        return $this->hasMany(TableCall::class);
    }

    public function latestCall()
    {
        return $this->hasOne(TableCall::class)->latestOfMany();
    }
}
