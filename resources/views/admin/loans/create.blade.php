{{-- resources/views/admin/loans/create.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">New Book Issue</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('loans.store') }}" method="POST">
                @csrf

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

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="loan_date" class="form-label">Book issue Date</label>
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

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary me-2">Save Issue Book</button>
                    <a href="{{ route('loans.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // If Laravel validation has an error on student_id, show SweetAlert too.
    @if($errors->has('student_id'))
        Swal.fire({
            icon: 'warning',
            title: 'Limit Reached!',
            text: @json($errors->first('student_id')),
            confirmButtonText: 'OK',
            confirmButtonColor: '#d33'
        });
    @endif
});
</script>
@endpush
