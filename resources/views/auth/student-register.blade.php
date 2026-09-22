@extends('layouts.guest')

@section('title', 'Student Sign Up - Skill Bridge NB')

@section('content')
    <h1 class="h4 mb-1">Create your student account</h1>
    <p class="text-muted mb-4">No password to remember - we'll email you a code every time you log in.</p>

    @if ($errors->any())
        <div class="alert alert-danger text-start py-2">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('student.register.submit') }}" class="text-start">
        @csrf
        <label for="name" class="form-label">Full name</label>
        <input type="text" name="name" id="name" class="form-control mb-3" value="{{ old('name') }}" required autofocus>

        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" id="email" class="form-control mb-3" value="{{ old('email') }}" required>

        <label for="phone" class="form-label">Phone (optional)</label>
        <input type="text" name="phone" id="phone" class="form-control mb-3" value="{{ old('phone') }}">

        <button type="submit" class="btn btn-primary w-100">Create account & send me a code</button>
    </form>
    <a href="{{ route('student.login') }}" class="small text-muted d-block mt-2">Already have an account? Log in</a>
@endsection
