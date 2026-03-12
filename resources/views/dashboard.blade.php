@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="p-5 mb-4 bg-light rounded-3 border shadow-sm">
        <h1 class="display-5 fw-bold text-primary">Civil Registrar's Office</h1>
        <p class="fs-4 text-muted">Manage and record municipal civil registry data efficiently.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-primary shadow-sm">
                <div class="card-body text-center">
                    <h3 class="card-title text-primary">Birth Records</h3>
                    <p class="display-6 fw-bold">{{ $counts['births'] }}</p>
                    <p class="text-secondary small">Total Registered Births</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('births.create') }}" class="btn btn-primary">Add New Record</a>
                        <a href="{{ route('births.index') }}" class="btn btn-outline-primary">View All List</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-success shadow-sm">
                <div class="card-body text-center">
                    <h3 class="card-title text-success">Marriage Records</h3>
                    <p class="display-6 fw-bold">{{ $counts['marriages'] }}</p>
                    <p class="text-secondary small">Total Registered Marriages</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('marriages.create') }}" class="btn btn-success">Add New Record</a>
                        <a href="{{ route('marriages.index') }}" class="btn btn-outline-success">View All List</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-danger shadow-sm">
                <div class="card-body text-center">
                    <h3 class="card-title text-danger">Death Records</h3>
                    <p class="display-6 fw-bold">{{ $counts['deaths'] }}</p>
                    <p class="text-secondary small">Total Registered Deaths</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('deaths.create') }}" class="btn btn-danger">Add New Record</a>
                        <a href="{{ route('deaths.index') }}" class="btn btn-outline-danger">View All List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
