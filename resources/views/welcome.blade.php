@extends('layouts.guest')

@section('title', 'Skill Bridge NB')

@section('content')
    <h1 class="h4 mb-1">Skill Bridge NB</h1>
    <p class="text-muted mb-4">Choose your portal to log in.</p>

    <div class="d-grid gap-2">
        <a href="{{ route('staff.login') }}" class="btn btn-primary">Staff Login</a>
        <a href="{{ route('student.login') }}" class="btn btn-outline-primary">Student Login</a>
        <a href="{{ route('agent.login') }}" class="btn btn-outline-primary">Agent Login</a>
    </div>
@endsection
