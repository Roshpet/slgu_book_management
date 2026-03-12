@extends('layouts.app')

@section('content')
<style>
    /* 1. Fix the height and prevent scrolling */
    body, html {
        height: 100%;
        margin: 0;
        overflow: hidden;
    }

    .splash-wrapper {
        position: relative;
        height: 100vh;
        width: 100vw;
        display: flex;
        flex-direction: column; /* Stacks items vertically */
        justify-content: center; /* Centers vertically */
        align-items: center; /* Centers horizontally */
        cursor: pointer;
        text-align: center;
    }

    /* 2. The Background Image Layer */
    .splash-wrapper::before {
        content: "";
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        /* Ensure the image name matches your file in public/images/ */
        background-image: url("{{ asset('images/sogod-municipal.jpg') }}");
        background-size: cover;
        background-position: center;
        filter: blur(5px); /* Adjusted blur for better visibility */
        z-index: -1;
        transform: scale(1.1); /* Hides white edges from the blur */
    }

    /* 3. Content Styling */
    .seal-img {
        width: 400px; /* Adjust based on your preference */
        max-width: 80%;
        filter: drop-shadow(0px 10px 20px rgba(0,0,0,0.4));
        margin-bottom: 20px;
    }

    .system-title {
        color: white;
        font-weight: 800;
        font-size: 2.5rem;
        text-transform: uppercase;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.8);
        margin: 0;
    }

    .continue-text {
        color: white;
        font-size: 1.2rem;
        margin-top: 30px;
        text-shadow: 1px 1px 4px rgba(0,0,0,0.8);
        animation: blinker 1.5s linear infinite;
    }

    @keyframes blinker { 50% { opacity: 0; } }
</style>

<div class="splash-wrapper" id="splash">
    <img src="{{ asset('images/sogod-logo.png') }}" alt="Municipality of Sogod Seal" class="seal-img">

    <h1 class="system-title">Civil Registry System</h1>
    <p class="continue-text">Press any key or click to continue</p>
</div>

<script>
    function goToDashboard() {
        window.location.href = "{{ route('dashboard') }}";
    }
    document.addEventListener('keydown', goToDashboard);
    document.getElementById('splash').addEventListener('click', goToDashboard);
</script>
@endsection
