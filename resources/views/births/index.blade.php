@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Birth Records List</h4>
            <div class="d-flex gap-2">
                <form action="{{ route('births.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search name or Reg No...">
                    <button type="submit" class="btn btn-light btn-sm">Search</button>
                </form>
                <a href="{{ route('births.create') }}" class="btn btn-light btn-sm">Add New Record</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Reg. Date</th>
                            <th>Reg. No.</th>
                            <th>Full Name</th>
                            <th>Date of Birth</th>
                            <th>Mother's Name</th>
                            <th>Father's Name</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($births as $birth)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($birth->date_of_registration)->format('M d, Y') }}</td>
                                <td>{{ $birth->registration_number }}</td>
                                <td>{{ $birth->full_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($birth->date_of_birth)->format('M d, Y') }}</td>
                                <td>{{ $birth->name_of_mother }}</td>
                                <td>{{ $birth->name_of_father }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-info btn-sm text-white">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection