<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Concerns\HandlesOtpAuthentication;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentAuthController extends Controller
{
    use HandlesOtpAuthentication;

    /**
     * Students are the only guard that can sign themselves up - staff and
     * agents are created by a Super Admin/Manager instead (see TeamController).
     */
    public function showRegisterForm(): View
    {
        return view('auth.student-register');
    }

    public function register(Request $request, OtpService $otp): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:students,email'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $student = Student::create($data);
        $student->update(['student_number' => 'SB'.str_pad((string) $student->id, 5, '0', STR_PAD_LEFT)]);

        $error = $otp->generateAndSend('student', $student->email);

        if ($error) {
            return back()->withInput()->withErrors(['email' => $error]);
        }

        $request->session()->put('student_otp_email', $student->email);

        return redirect()->route('student.login.verify');
    }

    protected function guardName(): string
    {
        return 'student';
    }

    protected function modelClass(): string
    {
        return Student::class;
    }

    protected function portalLabel(): string
    {
        return 'Student';
    }

    protected function dashboardRoute(): string
    {
        return 'student.dashboard';
    }

    protected function loginRoute(): string
    {
        return 'student.login';
    }
}
