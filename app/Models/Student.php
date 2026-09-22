<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    protected $table = 'students';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'student_number',
        'last_login_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'last_login_at' => 'datetime',
    ];
}
