@extends('layouts.guest')

@section('title', 'Student Dashboard - Skill Bridge NB')

@section('content')
    <h1 class="h4 mb-1">Welcome, {{ auth('student')->user()->name }}</h1>
    <p class="text-muted mb-4">You're logged in to the Student portal.</p>
    <p class="small text-muted mb-4">This is a placeholder - the admission application form lands here next.</p>
    <form method="POST" action="{{ route('student.logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-secondary w-100">Log out</button>
    </form>
@endsection
