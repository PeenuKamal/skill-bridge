<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Staff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Only a Super Admin or Manager can create Staff or Agent accounts -
 * students are the only ones who sign themselves up (see StudentAuthController).
 */
class TeamController extends Controller
{
    public const MANAGING_ROLES = ['super_admin', 'manager'];

    public const STAFF_ROLES = [
        'super_admin',
        'manager',
        'admission_counsellor',
        'receptionist',
        'student_coordinator',
        'accounts',
    ];

    protected function ensureCanManage(): void
    {
        abort_unless(
            in_array(auth('staff')->user()->role, self::MANAGING_ROLES, true),
            403,
            'Only a Super Admin or Manager can manage the team.'
        );
    }

    public function index(): View
    {
        $this->ensureCanManage();

        return view('staff.team.index', [
            'staff' => Staff::orderBy('name')->get(),
            'agents' => Agent::orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        $this->ensureCanManage();

        return view('staff.team.create', [
            'staffRoles' => self::STAFF_ROLES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureCanManage();

        $type = $request->input('type');

        if ($type === 'staff') {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:staff,email'],
                'phone' => ['nullable', 'string', 'max:30'],
                'role' => ['required', 'in:'.implode(',', self::STAFF_ROLES)],
            ]);

            Staff::create($data);

            return redirect()->route('staff.team.index')->with('status', 'Staff account created.');
        }

        if ($type === 'agent') {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:agents,email'],
                'phone' => ['nullable', 'string', 'max:30'],
                'agency_name' => ['nullable', 'string', 'max:255'],
                'commission_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            ]);

            Agent::create($data);

            return redirect()->route('staff.team.index')->with('status', 'Agent account created.');
        }

        return back()->withErrors(['type' => 'Please choose Staff or Agent.']);
    }
}
