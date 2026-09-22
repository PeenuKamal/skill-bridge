<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Agent extends Authenticatable
{
    protected $table = 'agents';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'agency_name',
        'commission_rate',
        'last_login_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'last_login_at' => 'datetime',
    ];
}
