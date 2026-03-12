@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h4 class="mb-0">Death Records List</h4>

            <div class="d-flex gap-2">
                <form action="{{ route('deaths.index') }}" method="GET" class="d-flex gap-1">
                    <input type="text" name="search" class="form-control form-control-sm"
                           placeholder="Search name or Reg No..."
                           value="{{ request('search') }}" style="width: 200px;">
                    <button class="btn btn-light btn-sm fw-bold" type="submit">Search</button>
                    @if(request('search'))
                        <a href="{{ route('deaths.index') }}" class="btn btn-secondary btn-sm">Clear</a>
                    @endif
                </form>

                <a href="{{ route('deaths.create') }}" class="btn btn-light btn-sm fw-bold">Add New Record</a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Reg. Date</th>
                            <th>Reg. No.</th>
                            <th>Full Name</th>
                            <th>Place of Birth</th>
                            <th>Age</th>
                            <th>Date of Death</th>
                            <th>Cause of Death</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deaths as $death)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($death->date_of_registration)->format('M d, Y') }}</td>
                                <td class="fw-bold">{{ $death->registration_number }}</td>
                                <td>{{ $death->full_name }}</td>
                                <td>{{ $death->place_of_birth }}</td>
                                <td>{{ $death->age }}</td>
                                <td>{{ \Carbon\Carbon::parse($death->date_of_death)->format('M d, Y') }}</td>
                                <td>{{ $death->cause_of_death }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-info btn-sm text-white">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
