@extends('layouts.app')

@section('content')
<style>
    /* Force text to appear as uppercase in the UI */
    input[type="text"],
    select,
    textarea {
        text-transform: uppercase;
    }
</style>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add New Birth Record</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('births.store') }}" method="POST" id="birthForm">
                @csrf

                <h5 class="text-primary border-bottom pb-2 mb-3">Administrative Details</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Book No.</label>
                        <input type="text" name="book_number" class="form-control @error('book_number') is-invalid @enderror" value="{{ old('book_number') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Page No.</label>
                        <input type="text" name="page_number" class="form-control @error('page_number') is-invalid @enderror" value="{{ old('page_number') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Date of Registration</label>
                        <input type="date" name="date_of_registration" id="date_of_reg"
                               class="form-control @error('date_of_registration') is-invalid @enderror"
                               value="{{ old('date_of_registration') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Reg. No.</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold" id="year_prefix">
                                {{ old('date_of_registration') ? explode('-', old('date_of_registration'))[0] : date('Y') }}-
                            </span>
                            <input type="text" name="reg_sequence" id="reg_sequence"
                                   class="form-control @error('registration_number') is-invalid @enderror"
                                   value="{{ old('reg_sequence') }}" required placeholder="Number">
                        </div>
                        <input type="hidden" name="registration_number" id="reg_no_full" value="{{ old('registration_number') }}">
                    </div>
                </div>

                <h5 class="text-primary border-bottom pb-2 mb-3">Child's Personal Details</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Full Name of Child</label>
                        <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Sex</label>
                        <select name="sex" class="form-select @error('sex') is-invalid @enderror" required>
                            <option value="" selected disabled>Select Sex</option>
                            <option value="MALE" {{ old('sex') == 'MALE' ? 'selected' : '' }}>MALE</option>
                            <option value="FEMALE" {{ old('sex') == 'FEMALE' ? 'selected' : '' }}>FEMALE</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Nationality (Child)</label>
                        <input type="text" name="nationality" class="form-control" value="{{ old('nationality', 'FILIPINO') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}" required>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-bold">Place of Birth</label>
                        <input type="text" name="place_of_birth" class="form-control @error('place_of_birth') is-invalid @enderror" value="{{ old('place_of_birth') }}" required>
                    </div>
                </div>

                <h5 class="text-primary border-bottom pb-2 mb-3">Parents' Information</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Mother's Full Name</label>
                        <input type="text" name="name_of_mother" class="form-control @error('name_of_mother') is-invalid @enderror" value="{{ old('name_of_mother') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Mother's Nationality</label>
                        <input type="text" name="mother_nationality" class="form-control" value="{{ old('mother_nationality', 'FILIPINO') }}" required>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-bold">Father's Full Name</label>
                        <input type="text" name="name_of_father" id="father_name" class="form-control @error('name_of_father') is-invalid @enderror" value="{{ old('name_of_father') }}" required placeholder="Type UNKNOWN if not applicable">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Father's Nationality</label>
                        <input type="text" name="father_nationality" id="father_nationality" class="form-control" value="{{ old('father_nationality', 'FILIPINO') }}" required>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-bold">Place of Marriage (Parents)</label>
                        <input type="text" name="place_of_marriage" id="place_of_marriage" class="form-control" value="{{ old('place_of_marriage') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Date of Marriage (Parents)</label>
                        <input type="date" name="date_of_marriage" id="date_of_marriage" class="form-control" value="{{ old('date_of_marriage') }}">
                    </div>
                </div>

                <div class="mt-4 border-top pt-3">
                    <button type="submit" id="save_btn" class="btn btn-primary px-5 fw-bold" disabled>Save Birth Record</button>
                    <a href="{{ route('births.index') }}" class="btn btn-secondary px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('birthForm');
        const saveBtn = document.getElementById('save_btn');
        const requiredInputs = form.querySelectorAll('[required]');

        // --- GLOBAL UPPERCASE LOGIC ---
        // This handles all text inputs and makes the data uppercase before submission
        form.querySelectorAll('input[type="text"]').forEach(input => {
            input.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
                checkFormCompletion();
            });
        });

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
        const fatherNat = document.getElementById('father_nationality');
        const placeMarriage = document.getElementById('place_of_marriage');
        const dateMarriage = document.getElementById('date_of_marriage');

        fatherInput.addEventListener('input', function() {
            const val = this.value.trim().toUpperCase(); // Already handled by global uppercase listener, but kept for safety
            if (val === "UNKNOWN") {
                placeMarriage.value = "N/A";
                placeMarriage.readOnly = true;

                dateMarriage.type = "text";
                dateMarriage.value = "N/A";
                dateMarriage.readOnly = true;

                fatherNat.value = "N/A";
                fatherNat.readOnly = true;
            } else {
                if (placeMarriage.value === "N/A") {
                    placeMarriage.value = "";
                    placeMarriage.readOnly = false;

                    dateMarriage.type = "date";
                    dateMarriage.value = "";
                    dateMarriage.readOnly = false;

                    fatherNat.value = "FILIPINO";
                    fatherNat.readOnly = false;
                }
            }
            checkFormCompletion();
        });

        checkFormCompletion();
    });
</script>
@endsection
