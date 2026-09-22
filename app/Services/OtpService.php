<?php

namespace App\Services;

use App\Mail\OtpCodeMail;
use App\Models\OtpCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

/**
 * Handles the whole "log in with email + one-time code" flow, shared by the
 * staff, student, and agent portals. Nobody in this system has a password -
 * this class is the entire login security model, so keep changes here small
 * and deliberate.
 */
class OtpService
{
    /** How long a code stays valid. */
    protected int $expiryMinutes = 10;

    /** How many wrong attempts are allowed before a code is dead. */
    protected int $maxAttempts = 5;

    /** How many seconds must pass before the same email can request another code. */
    protected int $resendCooldownSeconds = 45;

    /**
     * Returns null on success, or a string error message if the person must
     * wait before requesting another code.
     */
    public function generateAndSend(string $guard, string $email): ?string
    {
        $recent = OtpCode::where('guard', $guard)
            ->where('email', $email)
            ->latest('id')
            ->first();

        if ($recent && $recent->created_at->diffInSeconds(now()) < $this->resendCooldownSeconds) {
            $wait = $this->resendCooldownSeconds - $recent->created_at->diffInSeconds(now());

            return "Please wait {$wait} seconds before requesting another code.";
        }

        $code = (string) random_int(100000, 999999);

        OtpCode::create([
            'guard' => $guard,
            'email' => $email,
            'code_hash' => Hash::make($code),
            'attempts' => 0,
            'expires_at' => now()->addMinutes($this->expiryMinutes),
        ]);

        Mail::to($email)->send(new OtpCodeMail($code, $this->expiryMinutes));

        return null;
    }

    /**
     * Returns null on success, or a string error message describing why the
     * code did not verify.
     */
    public function verify(string $guard, string $email, string $code): ?string
    {
        $otp = OtpCode::where('guard', $guard)
            ->where('email', $email)
            ->whereNull('consumed_at')
            ->latest('id')
            ->first();

        if (! $otp) {
            return 'We could not find a pending code for that email. Please request a new one.';
        }

        if ($otp->expires_at->isPast()) {
            return 'That code has expired. Please request a new one.';
        }

        if ($otp->attempts >= $this->maxAttempts) {
            return 'Too many incorrect attempts. Please request a new code.';
        }

        if (! Hash::check($code, $otp->code_hash)) {
            $otp->increment('attempts');

            return 'That code is incorrect. Please try again.';
        }

        $otp->update(['consumed_at' => now()]);

        return null;
    }
}
