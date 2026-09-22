@extends('layouts.guest')

@section('title', 'Agent Dashboard - Skill Bridge NB')

@section('content')
    <h1 class="h4 mb-1">Welcome, {{ auth('agent')->user()->name }}</h1>
    <p class="text-muted mb-4">You're logged in to the Agent portal.</p>
    <p class="small text-muted mb-4">This is a placeholder - referred students and commission tracking land here next.</p>
    <form method="POST" action="{{ route('agent.logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-secondary w-100">Log out</button>
    </form>
@endsection
