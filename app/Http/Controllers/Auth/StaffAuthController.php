<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Concerns\HandlesOtpAuthentication;
use App\Http\Controllers\Controller;
use App\Models\Staff;

class StaffAuthController extends Controller
{
    use HandlesOtpAuthentication;

    protected function guardName(): string
    {
        return 'staff';
    }

    protected function modelClass(): string
    {
        return Staff::class;
    }

    protected function portalLabel(): string
    {
        return 'Staff';
    }

    protected function dashboardRoute(): string
    {
        return 'staff.dashboard';
    }

    protected function loginRoute(): string
    {
        return 'staff.login';
    }
}
