@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add New Death Record</h4>
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

            <form action="{{ route('deaths.store') }}" method="POST" id="deathForm">
                @csrf

                <div class="row g-3">
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

                    <hr class="my-2">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Full Name of Deceased</label>
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
                        <label class="form-label fw-bold">Nationality</label>
                        <input type="text" name="nationality" class="form-control @error('nationality') is-invalid @enderror" value="{{ old('nationality', 'FILIPINO') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Age</label>
                        <input type="number" name="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Civil Status</label>
                        <select name="civil_status" class="form-select" required>
                            <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            <option value="Separated" {{ old('civil_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Occupation</label>
                        <input type="text" name="occupation" class="form-control @error('occupation') is-invalid @enderror" value="{{ old('occupation') }}" required>
                    </div>

                    <hr class="my-2">

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Date of Death</label>
                        <input type="date" name="date_of_death" id="date_of_death" class="form-control @error('date_of_death') is-invalid @enderror" value="{{ old('date_of_death') }}" required>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-bold">Place of Death</label>
                        <input type="text" name="place_of_death" class="form-control @error('place_of_death') is-invalid @enderror" value="{{ old('place_of_death') }}" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Cause of Death</label>
                        <textarea name="cause_of_death" class="form-control @error('cause_of_death') is-invalid @enderror" rows="2" required>{{ old('cause_of_death') }}</textarea>
                    </div>
                </div>

                <div class="mt-4 border-top pt-3">
                    <button type="submit" id="save_btn" class="btn btn-primary px-5 fw-bold" disabled>Save Death Record</button>
                    <a href="{{ route('deaths.index') }}" class="btn btn-secondary px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('deathForm');
        const saveBtn = document.getElementById('save_btn');

        function checkFormCompletion() {
            const requiredInputs = form.querySelectorAll('[required]');
            let isComplete = true;
            requiredInputs.forEach(input => {
                if (input.value.trim() === "") isComplete = false;
            });
            saveBtn.disabled = !isComplete;
        }

        form.addEventListener('input', checkFormCompletion);
        form.addEventListener('change', checkFormCompletion);

        // Registration Year Sync Logic
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

        // Initial check for 'old' values
        checkFormCompletion();
    });
</script>
@endsection
