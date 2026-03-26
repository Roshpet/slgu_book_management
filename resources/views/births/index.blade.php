@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h4 class="mb-0">Birth Records List</h4>
            <div class="d-flex gap-2">
                <form action="{{ route('births.index') }}" method="GET" class="d-flex gap-1">
                    <input type="text" name="search" class="form-control form-control-sm"
                           placeholder="Search name, Reg No, or Month Year..."
                           value="{{ request('search') }}" style="width: 250px;">
                    <button type="submit" class="btn btn-light btn-sm fw-bold">Search</button>
                    @if(request('search'))
                        <a href="{{ route('births.index') }}" class="btn btn-secondary btn-sm text-white">Clear</a>
                    @endif
                </form>

                <a href="{{ route('births.pdf', ['search' => request('search')]) }}" class="btn btn-danger btn-sm fw-bold">Export PDF</a>
                <a href="{{ route('births.create') }}" class="btn btn-light btn-sm fw-bold">Add New Record</a>
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
                            <th>Sex</th>
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
                                <td class="fw-bold">{{ $birth->registration_number }}</td>
                                <td>{{ strtoupper($birth->full_name) }}</td>
                                <td>{{ $birth->sex }}</td>
                                <td>{{ \Carbon\Carbon::parse($birth->date_of_birth)->format('M d, Y') }}</td>
                                <td>{{ strtoupper($birth->name_of_mother) }}</td>
                                <td>{{ strtoupper($birth->name_of_father) }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm text-white"
                                            data-bs-toggle="modal"
                                            data-bs-target="#printModal{{ $birth->id }}">
                                        View
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="printModal{{ $birth->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content text-dark">
                                        <form id="printForm{{ $birth->id }}" action="{{ route('births.docx', $birth->id) }}" method="GET">
                                            <div class="modal-header bg-light">
                                                <h5 class="modal-title">Official Receipt & Issuance Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3 text-start">
                                                    <label class="form-label fw-bold">Issued To (Requester Name)</label>
                                                    <div class="input-group">
                                                        <input type="text" name="issued_to" class="form-control" placeholder="Full Name" required style="flex: 3;">
                                                        <select name="gender_ref" class="form-select" style="flex: 1;" required>
                                                            <option selected disabled value="">Gender</option>
                                                            <option value="his">his</option>
                                                            <option value="her">her</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3 text-start">
                                                        <label class="form-label fw-bold">O.R. Number</label>
                                                        <input type="text" name="or_number" class="form-control" placeholder="1366891" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3 text-start">
                                                        <label class="form-label fw-bold">Amount Paid</label>
                                                        <input type="text" name="amount_paid" class="form-control" value="P355.00" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-between">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-danger" onclick="setPrintTarget('{{ $birth->id }}', 'pdf')">
                                                        Generate PDF
                                                    </button>
                                                    <button type="submit" class="btn btn-success" onclick="setPrintTarget('{{ $birth->id }}', 'docx')">
                                                        Generate Editable Docx
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function setPrintTarget(id, type) {
        const form = document.getElementById('printForm' + id);
        const timestamp = new Date().getTime();

        if (type === 'pdf') {
            let url = "{{ route('births.single_pdf', ':id') }}?t=" + timestamp;
            form.action = url.replace(':id', id);
            form.target = "_blank";
        } else {
            let url = "{{ route('births.docx', ':id') }}";
            form.action = url.replace(':id', id);
            form.target = "_self";
        }
    }
</script>
@endsection
