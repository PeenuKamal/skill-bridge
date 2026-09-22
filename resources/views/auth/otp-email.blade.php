@extends('layouts.guest')

@section('title', $portalLabel . ' Login - Skill Bridge NB')

@section('content')
    <h1 class="h4 mb-1">{{ $portalLabel }} Login</h1>
    <p class="text-muted mb-4">Enter your email and we'll send you a one-time code. No password needed.</p>

    @if ($errors->any())
        <div class="alert alert-danger text-start py-2">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ $action }}" class="text-start">
        @csrf
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" id="email" class="form-control mb-3"
               value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
        <button type="submit" class="btn btn-primary w-100">Send me a code</button>
    </form>
    @if ($portalLabel === 'Student')
        <a href="{{ route('student.register') }}" class="small text-muted d-block mt-2">New student? Create an account</a>
    @endif
@endsection
