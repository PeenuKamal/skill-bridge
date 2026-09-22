@extends('layouts.guest')

@section('title', 'Team & Agents - Skill Bridge NB')

@section('content')
    <h1 class="h4 mb-1">Team & Agents</h1>
    <p class="text-muted mb-3">Only visible to Super Admins and Managers.</p>

    @if (session('status'))
        <div class="alert alert-success py-2">{{ session('status') }}</div>
    @endif

    <a href="{{ route('staff.team.create') }}" class="btn btn-primary w-100 mb-4">+ Add Staff or Agent</a>

    <h2 class="h6 text-start">Staff</h2>
    <table class="table table-sm text-start">
        <thead><tr><th>Name</th><th>Email</th><th>Role</th></tr></thead>
        <tbody>
        @foreach ($staff as $member)
            <tr><td>{{ $member->name }}</td><td>{{ $member->email }}</td><td>{{ $member->role }}</td></tr>
        @endforeach
        </tbody>
    </table>

    <h2 class="h6 text-start mt-4">Agents</h2>
    <table class="table table-sm text-start">
        <thead><tr><th>Name</th><th>Email</th><th>Commission %</th></tr></thead>
        <tbody>
        @foreach ($agents as $agent)
            <tr><td>{{ $agent->name }}</td><td>{{ $agent->email }}</td><td>{{ $agent->commission_rate ?? '-' }}</td></tr>
        @endforeach
        </tbody>
    </table>

    <a href="{{ route('staff.dashboard') }}" class="small text-muted">Back to dashboard</a>
@endsection
