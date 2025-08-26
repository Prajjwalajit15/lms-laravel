@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Add New Loan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('loans.store') }}" method="POST">
                @csrf

                <!-- Row 1: Book + Student -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="book_id" class="form-label">Select Book</label>
                        <select name="book_id" id="book_id"
                                class="form-control @error('book_id') is-invalid @enderror">
                            <option value="">-- Choose Book --</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="student_id" class="form-label">Select Student</label>
                        <select name="student_id" id="student_id"
                                class="form-control @error('student_id') is-invalid @enderror">
                            <option value="">-- Choose Student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Row 2: Loan Date + Return Date -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="loan_date" class="form-label">Loan Date</label>
                        <input type="date" name="loan_date" id="loan_date"
                               class="form-control @error('loan_date') is-invalid @enderror"
                               value="{{ old('loan_date') }}">
                        @error('loan_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="return_date" class="form-label">Return Date</label>
                        <input type="date" name="return_date" id="return_date"
                               class="form-control @error('return_date') is-invalid @enderror"
                               value="{{ old('return_date') }}">
                        @error('return_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary me-2">Save Loan</button>
                    <a href="{{ route('loans.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ✅ SweetAlert Warning --}}
@if(session('loan_limit_warning'))
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Limit Reached!',
        text: '{{ session('loan_limit_warning') }}',
        confirmButtonText: 'OK',
        confirmButtonColor: '#d33'
    })
</script>
@endif
@endsection
