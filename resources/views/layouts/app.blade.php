<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Civil Registry System - Sogod</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ensures the splash screen can take up the full height without margins */
        body, html {
            height: 100%;
            margin: 0;
        }
    </style>
</head>
<body>
    {{-- Only show the navbar if NOT on the welcome/splash page --}}
    @if(!Request::is('/'))
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Registry System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Home</a>
                    <a class="nav-link {{ Request::is('births*') ? 'active' : '' }}" href="{{ route('births.index') }}">Births</a>
                    <a class="nav-link {{ Request::is('marriages*') ? 'active' : '' }}" href="{{ route('marriages.index') }}">Marriages</a>
                    <a class="nav-link {{ Request::is('deaths*') ? 'active' : '' }}" href="{{ route('deaths.index') }}">Deaths</a>
                </div>
            </div>
        </div>
    </nav>
    @endif

    {{-- Use container-fluid for the splash screen to allow edge-to-edge background images --}}
    <div class="{{ Request::is('/') ? 'container-fluid p-0' : 'container' }}">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
