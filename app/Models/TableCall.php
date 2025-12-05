<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableCall extends Model
{
    protected $fillable = [
        'table_id',
        'status',
        'called_at',
        'acknowledged_at',
        'completed_at'
    ];

    protected $casts = [
        'called_at' => 'datetime',
        'acknowledged_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
