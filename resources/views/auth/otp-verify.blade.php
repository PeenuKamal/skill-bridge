@extends('layouts.guest')

@section('title', $portalLabel . ' Login - Skill Bridge NB')

@section('content')
    <h1 class="h4 mb-1">Enter your code</h1>
    <p class="text-muted mb-4">We sent a 6-digit code to <strong>{{ $email }}</strong>.</p>

    @if ($errors->any())
        <div class="alert alert-danger text-start py-2">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ $action }}" class="text-start">
        @csrf
        <label for="code" class="form-label">6-digit code</label>
        <input type="text" name="code" id="code" class="form-control mb-3 text-center"
               style="letter-spacing: 6px; font-size: 24px;"
               maxlength="6" inputmode="numeric" pattern="[0-9]*" placeholder="000000" required autofocus>
        <button type="submit" class="btn btn-primary w-100 mb-2">Verify & Log In</button>
    </form>
    <a href="{{ $backRoute }}" class="small text-muted">Use a different email</a>
@endsection
