@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h4 class="mb-0">Add New Birth Record</h4>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('births.store') }}" method="POST" id="birthForm">
            @csrf
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Book No.</label>
                    <input type="text" name="book_number" class="form-control @error('book_number') is-invalid @enderror" value="{{ old('book_number') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Page No.</label>
                    <input type="text" name="page_number" class="form-control @error('page_number') is-invalid @enderror" value="{{ old('page_number') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Date of Registration</label>
                    <input type="date" name="date_of_registration" id="date_of_reg"
                           class="form-control @error('date_of_registration') is-invalid @enderror"
                           value="{{ old('date_of_registration') }}" required>
                    @error('date_of_registration')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Reg. No.</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light fw-bold" id="year_prefix">
                            {{ old('date_of_registration') ? explode('-', old('date_of_registration'))[0] : date('Y') }}-
                        </span>

                        <input type="text" name="reg_sequence" id="reg_sequence"
                               class="form-control @error('registration_number') is-invalid @enderror"
                               value="{{ old('reg_sequence') }}" required placeholder="Number">
                    </div>

                    <input type="hidden" name="registration_number" id="reg_no_full" value="{{ old('registration_number') }}">

                    @error('registration_number')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-3"> <div class="col-md-4">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Place of Birth</label>
                    <input type="text" name="place_of_birth" class="form-control @error('place_of_birth') is-invalid @enderror" value="{{ old('place_of_birth') }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Nationality</label>
                    <input type="text" name="nationality" class="form-control" value="{{ old('nationality', 'Filipino') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Mother's Name</label>
                    <input type="text" name="name_of_mother" class="form-control @error('name_of_mother') is-invalid @enderror" value="{{ old('name_of_mother') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Father's Name</label>
                    <input type="text" name="name_of_father" id="father_name" class="form-control @error('name_of_father') is-invalid @enderror" value="{{ old('name_of_father') }}" required placeholder="Type UNKNOWN if not applicable">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Place of Marriage (Parents)</label>
                    <input type="text" name="place_of_marriage" id="place_of_marriage" class="form-control" value="{{ old('place_of_marriage') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date of Marriage (Parents)</label>
                    <input type="date" name="date_of_marriage" id="date_of_marriage" class="form-control" value="{{ old('date_of_marriage') }}">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" id="save_btn" class="btn btn-primary px-4" disabled>Save Birth Record</button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('birthForm');
        const saveBtn = document.getElementById('save_btn');
        const requiredInputs = form.querySelectorAll('[required]');

        // Check if all required fields are filled to enable Save button
        function checkFormCompletion() {
            let isComplete = true;
            requiredInputs.forEach(input => {
                if (input.value.trim() === "") {
                    isComplete = false;
                }
            });
            saveBtn.disabled = !isComplete;
        }

        requiredInputs.forEach(input => {
            input.addEventListener('input', checkFormCompletion);
            input.addEventListener('change', checkFormCompletion);
        });

        // Registration Year Sync Logic
        const dateInput = document.getElementById('date_of_reg');
        const yearPrefix = document.getElementById('year_prefix');
        const regSequence = document.getElementById('reg_sequence');
        const regFull = document.getElementById('reg_no_full');

        function updateFullValue() {
            regFull.value = yearPrefix.textContent.trim() + regSequence.value;
            checkFormCompletion();
        }

        dateInput.addEventListener('change', function() {
            if (this.value) {
                const selectedYear = this.value.split('-')[0];
                yearPrefix.textContent = selectedYear + '-';
                updateFullValue();
            }
        });

        regSequence.addEventListener('input', updateFullValue);

        // Unknown Father Logic
        const fatherInput = document.getElementById('father_name');
        const placeMarriage = document.getElementById('place_of_marriage');
        const dateMarriage = document.getElementById('date_of_marriage');

        fatherInput.addEventListener('input', function() {
            const val = this.value.trim().toUpperCase();
            if (val === "UNKNOWN") {
                placeMarriage.value = "N/A";
                placeMarriage.readOnly = true;
                dateMarriage.type = "text";
                dateMarriage.value = "N/A";
                dateMarriage.readOnly = true;
            } else {
                if (placeMarriage.value === "N/A") {
                    placeMarriage.value = "";
                    placeMarriage.readOnly = false;
                    dateMarriage.type = "date";
                    dateMarriage.value = "";
                    dateMarriage.readOnly = false;
                }
            }
            checkFormCompletion();
        });

        checkFormCompletion();
    });
</script>
@endsection
