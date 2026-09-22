<?php

namespace App\Http\Controllers\Auth\Concerns;

use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Shared email + one-time-code login flow, used by the staff, student, and
 * agent portals. Each controller that uses this trait must define:
 *
 *   guardName()      e.g. 'staff'
 *   modelClass()     e.g. \App\Models\Staff::class
 *   portalLabel()    e.g. 'Staff'
 *   dashboardRoute() e.g. 'staff.dashboard'
 *   loginRoute()     e.g. 'staff.login'
 */
trait HandlesOtpAuthentication
{
    abstract protected function guardName(): string;

    abstract protected function modelClass(): string;

    abstract protected function portalLabel(): string;

    abstract protected function dashboardRoute(): string;

    abstract protected function loginRoute(): string;

    public function showEmailForm(): View
    {
        return view('auth.otp-email', [
            'portalLabel' => $this->portalLabel(),
            'action' => route($this->loginRoute().'.send'),
        ]);
    }

    public function sendCode(Request $request, OtpService $otp): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $exists = ($this->modelClass())::where('email', $data['email'])->exists();

        if (! $exists) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'We could not find a '.strtolower($this->portalLabel()).' account with that email.']);
        }

        $error = $otp->generateAndSend($this->guardName(), $data['email']);

        if ($error) {
            return back()->withInput()->withErrors(['email' => $error]);
        }

        $request->session()->put($this->guardName().'_otp_email', $data['email']);

        return redirect()->route($this->loginRoute().'.verify');
    }

    public function showVerifyForm(Request $request): View|RedirectResponse
    {
        $email = $request->session()->get($this->guardName().'_otp_email');

        if (! $email) {
            return redirect()->route($this->loginRoute());
        }

        return view('auth.otp-verify', [
            'portalLabel' => $this->portalLabel(),
            'email' => $email,
            'action' => route($this->loginRoute().'.verify.submit'),
            'backRoute' => route($this->loginRoute()),
        ]);
    }

    public function verifyCode(Request $request, OtpService $otp): RedirectResponse
    {
        $email = $request->session()->get($this->guardName().'_otp_email');

        if (! $email) {
            return redirect()->route($this->loginRoute());
        }

        $data = $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $error = $otp->verify($this->guardName(), $email, $data['code']);

        if ($error) {
            return back()->withErrors(['code' => $error]);
        }

        $user = ($this->modelClass())::where('email', $email)->firstOrFail();
        $user->forceFill(['last_login_at' => now()])->save();

        Auth::guard($this->guardName())->login($user, remember: true);
        $request->session()->forget($this->guardName().'_otp_email');
        $request->session()->regenerate();

        return redirect()->route($this->dashboardRoute());
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard($this->guardName())->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($this->loginRoute());
    }
}
