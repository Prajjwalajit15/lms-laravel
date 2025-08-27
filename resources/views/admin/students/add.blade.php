@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-light text-center">
                    <h4 class="mb-0"><i class="bi bi-person-plus me-2"></i> Add New Student</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('students.store') }}" method="POST">
                        @csrf

                        <!-- Student Code & Name -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Student Code</label>
                                <input type="text" name="student_code" class="form-control" 
                                         value="{{ $studentCode }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Name</label>
                                <input type="text" name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" 
                                       placeholder="Enter student name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email & Course -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" 
                                       placeholder="Enter student email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Course</label>
                                <input type="text" name="course" 
                                       class="form-control @error('course') is-invalid @enderror" 
                                       value="{{ old('course') }}" 
                                       placeholder="Enter course/class">
                                @error('course')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone & Fee -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <input type="text" name="phone" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone') }}" 
                                       placeholder="Enter phone number">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Fee</label>
                                <input type="number" step="0.01" name="fee" id="fee"
                                       class="form-control @error('fee') is-invalid @enderror" 
                                       value="{{ old('fee') }}" 
                                       placeholder="Calculated fee" readonly>
                                @error('fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Joining From & To -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Joining From</label>
                                <input type="date" name="join_from" id="join_from"
                                       class="form-control @error('join_from') is-invalid @enderror"
                                       value="{{ old('join_from') }}">
                                @error('join_from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Joining To</label>
                                <input type="date" name="join_to" id="join_to"
                                       class="form-control @error('join_to') is-invalid @enderror"
                                       value="{{ old('join_to') }}">
                                @error('join_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Total Days -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Total Days</label>
                                <input type="number" name="total_days" id="total_days"
                                       class="form-control @error('total_days') is-invalid @enderror"
                                       value="{{ old('total_days') }}" readonly>
                                @error('total_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Address</label>
                                <textarea name="address" 
                                          class="form-control @error('address') is-invalid @enderror" 
                                          rows="3">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="row mt-3">
                            <div class="col-md-6 d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i> Save Student
                                </button>
                            </div>
                            <div class="col-md-6 d-grid">
                                <button type="button" class="btn btn-secondary" id="cancel-btn">
                                    <i class="bi bi-x-circle me-2"></i> Cancel
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Cancel button confirm
    document.getElementById("cancel-btn").addEventListener("click", function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Are you sure?",
            text: "Unsaved changes will be lost!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, go back",
            cancelButtonText: "Stay here"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('students.index') }}";
            }
        });
    });

    // Auto-calculate total days & fee
    const joinFrom = document.getElementById("join_from");
    const joinTo   = document.getElementById("join_to");
    const totalDays = document.getElementById("total_days");
    const fee      = document.getElementById("fee");

    const feePerDay = 100; 

    function calculateDaysAndFee() {
        if (joinFrom.value && joinTo.value) {
            const start = new Date(joinFrom.value);
            const end   = new Date(joinTo.value);

            if (end < start) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date Selection',
                    text: '"Joining To" date cannot be earlier than "Joining From" date.',
                    confirmButtonText: 'OK'
                });
                joinTo.value = '';  
                totalDays.value = '';
                fee.value = '';
                return;
            }

            const diffTime = end - start;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            totalDays.value = diffDays;

            // Calculate fee
            fee.value = diffDays * feePerDay;
        } else {
            totalDays.value = '';
            fee.value = '';
        }
    }

    joinFrom.addEventListener("change", calculateDaysAndFee);
    joinTo.addEventListener("change", calculateDaysAndFee);
    window.addEventListener("load", calculateDaysAndFee);

    // Success SweetAlert
    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: @json(session('success')),
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#e6ffed',
            color: '#2e7d32',
            iconColor: '#2e7d32',
            showClass: { popup: 'animate__animated animate__fadeInRight' },
            hideClass: { popup: 'animate__animated animate__fadeOutRight' }
        });
    @endif
</script>
@endpush
@endsection
