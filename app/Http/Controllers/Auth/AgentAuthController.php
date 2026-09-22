<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Concerns\HandlesOtpAuthentication;
use App\Http\Controllers\Controller;
use App\Models\Agent;

class AgentAuthController extends Controller
{
    use HandlesOtpAuthentication;

    protected function guardName(): string
    {
        return 'agent';
    }

    protected function modelClass(): string
    {
        return Agent::class;
    }

    protected function portalLabel(): string
    {
        return 'Agent';
    }

    protected function dashboardRoute(): string
    {
        return 'agent.dashboard';
    }

    protected function loginRoute(): string
    {
        return 'agent.login';
    }
}
