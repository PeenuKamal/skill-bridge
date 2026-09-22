<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Where to send someone who isn't logged in yet. We have three separate
     * portals, so send them to whichever one they were trying to reach
     * instead of one generic login page.
     */
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return null;
        }

        return match (true) {
            $request->is('staff*') => route('staff.login'),
            $request->is('student*') => route('student.login'),
            $request->is('agent*') => route('agent.login'),
            default => route('home'),
        };
    }
}
