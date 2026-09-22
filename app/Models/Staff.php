<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    protected $table = 'staff';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'last_login_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'last_login_at' => 'datetime',
    ];
}
