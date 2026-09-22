@extends('layouts.guest')

@section('title', 'Add Staff or Agent - Skill Bridge NB')

@section('content')
    <h1 class="h4 mb-3">Add Staff or Agent</h1>

    @if ($errors->any())
        <div class="alert alert-danger text-start py-2">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('staff.team.store') }}" class="text-start" x-data="{ type: 'staff' }">
        @csrf

        <label class="form-label">Account type</label>
        <select name="type" class="form-select mb-3" onchange="document.getElementById('staff-fields').style.display = this.value === 'staff' ? 'block' : 'none'; document.getElementById('agent-fields').style.display = this.value === 'agent' ? 'block' : 'none';">
            <option value="staff">Staff (internal team)</option>
            <option value="agent">Agent (education consultant)</option>
        </select>

        <label for="name" class="form-label">Full name</label>
        <input type="text" name="name" id="name" class="form-control mb-3" value="{{ old('name') }}" required>

        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" id="email" class="form-control mb-3" value="{{ old('email') }}" required>

        <label for="phone" class="form-label">Phone (optional)</label>
        <input type="text" name="phone" id="phone" class="form-control mb-3" value="{{ old('phone') }}">

        <div id="staff-fields">
            <label for="role" class="form-label">Staff role</label>
            <select name="role" id="role" class="form-select mb-3">
                @foreach ($staffRoles as $role)
                    <option value="{{ $role }}">{{ ucwords(str_replace('_', ' ', $role)) }}</option>
                @endforeach
            </select>
        </div>

        <div id="agent-fields" style="display: none;">
            <label for="agency_name" class="form-label">Agency name (optional)</label>
            <input type="text" name="agency_name" id="agency_name" class="form-control mb-3" value="{{ old('agency_name') }}">

            <label for="commission_rate" class="form-label">Commission % (optional)</label>
            <input type="number" step="0.01" name="commission_rate" id="commission_rate" class="form-control mb-3" value="{{ old('commission_rate') }}">
        </div>

        <button type="submit" class="btn btn-primary w-100">Create account</button>
    </form>
    <a href="{{ route('staff.team.index') }}" class="small text-muted d-block mt-2">Cancel</a>
@endsection
