<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'amount',
    ];

    protected $casts = [
        'amount' => 'float',
    ];
}
