@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Borrowed Books</h5>
            <a href="{{ route('loans.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('loans.update', $loan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Book (locked, cannot change) -->
                    <div class="col-md-6 mb-3">
                        <label for="book_id" class="form-label">Book</label>
                        <select name="book_id" id="book_id" class="form-select" disabled>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" {{ $loan->book_id == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }}
                                </option>
                            @endforeach
                        </select>
                        <!-- Keep book_id in hidden so it goes in request -->
                        <input type="hidden" name="book_id" value="{{ $loan->book_id }}">
                    </div>

                    <!-- Student -->
                    <div class="col-md-6 mb-3">
                        <label for="student_id" class="form-label">Select Student</label>
                        <select name="student_id" id="student_id" class="form-select" required>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ $loan->student_id == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <!-- Loan Date -->
                    <div class="col-md-6 mb-3">
                        <label for="loan_date" class="form-label">Borrowed Date</label>
                        <input type="date" name="loan_date" id="loan_date" class="form-control" value="{{ $loan->loan_date }}" required>
                    </div>

                    <!-- Expected Return Date -->
                    <div class="col-md-6 mb-3">
                        <label for="return_date" class="form-label">Expected Return Date</label>
                        <input type="date" name="return_date" id="return_date" class="form-control" value="{{ $loan->return_date }}" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Actual Return Date -->
                    <div class="col-md-6 mb-3">
                        <label for="actual_return_date" class="form-label">Actual Return Date</label>
                        <input type="date" name="actual_return_date" id="actual_return_date" class="form-control" value="{{ $loan->actual_return_date }}">
                        <small class="text-muted">Fill this when the student actually returns the book.</small>
                    </div>

                    <!-- Late Fee -->
                    <div class="col-md-6 mb-3">
                        <label for="late_fee" class="form-label">Late Fee (₹)</label>
                        <input type="number" step="0.01" name="late_fee" id="late_fee" class="form-control" value="{{ $loan->late_fee }}">
                        <small class="text-muted">Late fee will be auto-calculated if return is late.</small>
                    </div>
                </div>

                <div class="row">
                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="active" 
                                {{ $loan->status == 'active' ? 'selected' : '' }} 
                                {{ $loan->status == 'returned' || $loan->actual_return_date ? 'disabled' : '' }}>
                                Active
                            </option>
                            <option value="returned" 
                                {{ $loan->status == 'returned' ? 'selected' : '' }}
                                {{ !$loan->actual_return_date ? 'disabled' : '' }}>
                                Returned
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-save me-1"></i> Update Borrowed Books
                    </button>
                    <a href="{{ route('loans.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<!-- Add SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const loanDateInput = document.getElementById("loan_date");
    const returnDateInput = document.getElementById("return_date");
    const actualReturnInput = document.getElementById("actual_return_date");
    const form = document.querySelector("form");

    function parseDate(input) {
        if (!input) return null;
        const parts = input.split("-"); // yyyy-mm-dd
        return new Date(parts[0], parts[1] - 1, parts[2]);
    }

    form.addEventListener("submit", function (e) {
        const loanDate = parseDate(loanDateInput.value);
        const returnDate = parseDate(returnDateInput.value);
        const actualReturn = parseDate(actualReturnInput.value);

        // Condition 1: Loan Date cannot be after Expected Return Date
        if (loanDate && returnDate && loanDate > returnDate) {
            e.preventDefault();
            Swal.fire({
                icon: "error",
                title: "Invalid Dates",
                text: "Loan Date cannot be after Expected Return Date.",
            });
            return;
        }

        // Condition 2: Actual Return Date cannot be before Loan Date
        if (loanDate && actualReturn && actualReturn < loanDate) {
            e.preventDefault();
            Swal.fire({
                icon: "error",
                title: "Invalid Dates",
                text: "Actual Return Date cannot be before Loan Date.",
            });
            return;
        }
    });
});
</script>
