@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h4 class="mb-0">Add New Marriage Record</h4>
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

        <form action="{{ route('marriages.store') }}" method="POST" id="marriageForm">
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
                </div>

                <hr class="my-3">

                <div class="row g-4 mt-1">
                    <div class="col-md-6 border-end">
                        <h5 class="text-primary mb-3">Husband's Details</h5>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="husband_name" class="form-control" value="{{ old('husband_name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob_husband" class="form-control" value="{{ old('dob_husband') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Place of Birth</label>
                            <input type="text" name="place_of_birth_husband" class="form-control" value="{{ old('place_of_birth_husband') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nationality</label>
                            <input type="text" name="nationality_husband" class="form-control" value="{{ old('nationality_husband', 'Filipino') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Father's Name</label>
                            <input type="text" name="father_husband" class="form-control" value="{{ old('father_husband') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mother's Name</label>
                            <input type="text" name="mother_husband" class="form-control" value="{{ old('mother_husband') }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="text-danger mb-3">Wife's Details</h5>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="wife_name" class="form-control" value="{{ old('wife_name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob_wife" class="form-control" value="{{ old('dob_wife') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Place of Birth</label>
                            <input type="text" name="place_of_birth_wife" class="form-control" value="{{ old('place_of_birth_wife') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nationality</label>
                            <input type="text" name="nationality_wife" class="form-control" value="{{ old('nationality_wife', 'Filipino') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Father's Name</label>
                            <input type="text" name="father_wife" class="form-control" value="{{ old('father_wife') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mother's Name</label>
                            <input type="text" name="mother_wife" class="form-control" value="{{ old('mother_wife') }}" required>
                        </div>
                    </div>
                </div>

                <hr class="my-3">

                <div class="col-md-8">
                    <label class="form-label">Place of Marriage</label>
                    <input type="text" name="place_of_marriage" class="form-control" value="{{ old('place_of_marriage') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date of Marriage</label>
                    <input type="date" name="date_of_marriage" id="date_of_marriage" class="form-control @error('date_of_marriage') is-invalid @enderror" value="{{ old('date_of_marriage') }}" required>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" id="save_btn" class="btn btn-success px-4" disabled>Save Marriage Record</button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('marriageForm');
        const saveBtn = document.getElementById('save_btn');

        function checkFormCompletion() {
            // Re-select required inputs every check to catch any dynamic changes
            const requiredInputs = form.querySelectorAll('[required]');
            let isComplete = true;
            requiredInputs.forEach(input => {
                if (input.value.trim() === "") isComplete = false;
            });
            saveBtn.disabled = !isComplete;
        }

        form.addEventListener('input', checkFormCompletion);
        form.addEventListener('change', checkFormCompletion);

        const dateRegInput = document.getElementById('date_of_reg');
        const yearPrefix = document.getElementById('year_prefix');
        const regSequence = document.getElementById('reg_sequence');
        const regFull = document.getElementById('reg_no_full');

        function updateFullValue() {
            regFull.value = yearPrefix.textContent.trim() + regSequence.value;
            checkFormCompletion();
        }

        dateRegInput.addEventListener('change', function() {
            if (this.value) {
                const selectedYear = this.value.split('-')[0];
                yearPrefix.textContent = selectedYear + '-';
                updateFullValue();
            }
        });

        regSequence.addEventListener('input', updateFullValue);
        checkFormCompletion();
    });
</script>
@endsection
