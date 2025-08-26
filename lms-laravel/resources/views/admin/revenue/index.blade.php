@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Revenue Details</h1>

    <!-- Student Fees -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">Student Fees</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Fee Paid (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalStudentFees = 0; @endphp
                    @forelse($students as $student)
                        @php $totalStudentFees += $student->fee; @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $student->name }}</td>
                            <td>₹{{ number_format($student->fee, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No student fees recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($students) > 0)
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-end">Total Student Fees:</th>
                        <th>₹{{ number_format($totalStudentFees, 2) }}</th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <!-- Late Fees -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">Late Book Fees</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Book</th>
                        <th>Late Fee (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalLateFees = 0; @endphp
                    @forelse($loans as $loan)
                        @php $totalLateFees += $loan->late_fee; @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $loan->student->name ?? 'N/A' }}</td>
                            <td>{{ $loan->book->title ?? 'N/A' }}</td>
                            <td>₹{{ number_format($loan->late_fee, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No late fees recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($loans) > 0)
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total Late Fees:</th>
                        <th>₹{{ number_format($totalLateFees, 2) }}</th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <!-- Combined Total -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body text-center bg-success text-white">
            <h4 class="mb-3">Grand Total Revenue</h4>
            <p class="mb-1">Total Student Fees: <strong>₹{{ number_format($totalStudentFees, 2) }}</strong></p>
            <p class="mb-1">Total Late Fees: <strong>₹{{ number_format($totalLateFees, 2) }}</strong></p>
            <hr class="border-light">
            <h5>Total Revenue: ₹{{ number_format($totalStudentFees + $totalLateFees, 2) }}</h5>
        </div>
    </div>
</div>
@endsection
