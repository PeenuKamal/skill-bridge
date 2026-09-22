@extends('layouts.guest')

@section('title', 'Staff Dashboard - Skill Bridge NB')

@section('content')
    <h1 class="h4 mb-1">Welcome, {{ auth('staff')->user()->name }}</h1>
    <p class="text-muted mb-4">You're logged in to the Staff portal ({{ auth('staff')->user()->role }}).</p>
    <p class="small text-muted mb-4">This is a placeholder - admissions, CRM, and finance screens land here next.</p>

    @if (in_array(auth('staff')->user()->role, ['super_admin', 'manager']))
        <a href="{{ route('staff.team.index') }}" class="btn btn-outline-primary w-100 mb-2">Manage Team & Agents</a>
    @endif

    <form method="POST" action="{{ route('staff.logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-secondary w-100">Log out</button>
    </form>
@endsection
