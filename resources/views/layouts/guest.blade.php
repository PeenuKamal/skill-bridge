<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Skill Bridge NB')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f5f7; min-height: 100vh; display: flex; flex-direction: column; }
        main { flex: 1; }
        .auth-card { max-width: 420px; margin: 64px auto; }
        .brand-logo { max-height: 56px; margin-bottom: 16px; }
    </style>
</head>
<body>
    <main class="d-flex align-items-center">
        <div class="container">
            <div class="auth-card card shadow-sm">
                <div class="card-body p-4 text-center">
                    <img src="{{ asset('images/skill-logo.png') }}" alt="Skill Bridge NB" class="brand-logo">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
    @include('partials.footer')
</body>
</html>
