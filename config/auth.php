<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */

    'defaults' => [
        'guard' => 'staff',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Skill Bridge NB has three separate login types, none of which use
    | passwords - all of them log in with a one-time code sent by email.
    |
    |   staff    -> internal team (admissions, receptionist, coordinator, accounts, management)
    |   student  -> the student admission portal
    |   agent    -> commission-based education consultants / referral agents
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'staff' => [
            'driver' => 'session',
            'provider' => 'staff',
        ],

        'student' => [
            'driver' => 'session',
            'provider' => 'students',
        ],

        'agent' => [
            'driver' => 'session',
            'provider' => 'agents',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'staff' => [
            'driver' => 'eloquent',
            'model' => App\Models\Staff::class,
        ],

        'students' => [
            'driver' => 'eloquent',
            'model' => App\Models\Student::class,
        ],

        'agents' => [
            'driver' => 'eloquent',
            'model' => App\Models\Agent::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Kept only for the untouched default "users" table/guard that ships with
    | Laravel. None of our three real guards above use passwords at all, so
    | they have no entry here.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
