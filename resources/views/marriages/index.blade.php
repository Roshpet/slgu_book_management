@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-3">
            <h4 class="mb-0">Marriage Records List</h4>

            <div class="d-flex gap-2">
                <form action="{{ route('marriages.index') }}" method="GET" class="d-flex gap-1">
                    <input type="text" name="search" class="form-control form-control-sm"
                           placeholder="Search name or Reg No..."
                           value="{{ request('search') }}" style="width: 200px;">
                    <button class="btn btn-light btn-sm fw-bold" type="submit">Search</button>
                    @if(request('search'))
                        <a href="{{ route('marriages.index') }}" class="btn btn-secondary btn-sm text-white">Clear</a>
                    @endif
                </form>

                <a href="{{ route('marriages.create') }}" class="btn btn-light btn-sm fw-bold">Add New Record</a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Reg. Date</th>
                            <th>Reg. No.</th>
                            <th>Husband's Name</th>
                            <th>Wife's Name</th>
                            <th>Date of Marriage</th>
                            <th>Place of Marriage</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($marriages as $marriage)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($marriage->date_of_registration)->format('M d, Y') }}</td>
                                <td class="fw-bold">{{ $marriage->registration_number }}</td>
                                <td>{{ $marriage->husband_name }}</td>
                                <td>{{ $marriage->wife_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($marriage->date_of_marriage)->format('M d, Y') }}</td>
                                <td>{{ $marriage->place_of_marriage }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-info btn-sm text-white">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No marriage records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
