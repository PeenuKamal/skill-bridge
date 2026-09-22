<?php

namespace App\Console\Commands;

use App\Models\Agent;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Console\Command;

/**
 * This is ONLY for the very first account on a brand new install. After
 * that, the normal way accounts get created is:
 *
 *   - Students sign themselves up at /student/register
 *   - Staff and Agents are created by a Super Admin or Manager, from the
 *     "Team & Agents" screen inside the Staff portal (once logged in)
 *
 * But the very first Staff login has to come from somewhere, since nobody
 * exists yet to open that screen - that's what this command is for. Run it
 * once, for yourself, as a super_admin, then do everything else from the
 * website.
 *
 * Example:
 *   php artisan account:create staff "Jane Doe" jane@skillbridgenb.org super_admin
 */
class CreateAccountCommand extends Command
{
    protected $signature = 'account:create {guard : staff, student, or agent} {name} {email} {role=super_admin : staff only - super_admin, manager, admission_counsellor, receptionist, student_coordinator, accounts}';

    protected $description = 'One-time setup: create the first account of a given type so someone can log in';

    public function handle(): int
    {
        $guard = strtolower($this->argument('guard'));
        $name = $this->argument('name');
        $email = $this->argument('email');

        $model = match ($guard) {
            'staff' => Staff::class,
            'student' => Student::class,
            'agent' => Agent::class,
            default => null,
        };

        if (! $model) {
            $this->error("Unknown guard '{$guard}'. Use one of: staff, student, agent.");

            return self::FAILURE;
        }

        if ($model::where('email', $email)->exists()) {
            $this->error("A {$guard} account with that email already exists.");

            return self::FAILURE;
        }

        $attributes = ['name' => $name, 'email' => $email];

        if ($guard === 'staff') {
            $attributes['role'] = $this->argument('role');
        }

        $model::create($attributes);

        $this->info("Created {$guard} account for {$name} ({$email}). They can now log in at /{$guard}/login.");

        return self::SUCCESS;
    }
}
