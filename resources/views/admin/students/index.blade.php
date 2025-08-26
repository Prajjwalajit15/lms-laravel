@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0"><i class="bi bi-people"></i> Students</h1>
        <a href="{{ route('students.add') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> Add Student
        </a>
    </div>

    <!-- Search Form -->
    <div class="mb-4">
        <form class="search-form d-flex" role="search" method="GET" action="{{ route('students.index') }}">
            <div class="input-group shadow-sm">
                <input class="form-control" 
                       type="search" 
                       name="q"
                       placeholder="Search by name, email, or Student Code..." 
                       value="{{ request('q') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Student Code</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Joining From</th>
                        <th>Joining To</th>
                        <th>Total Days</th>
                        <th>Fee</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr class="text-center align-middle">
                            <td>{{ $loop->iteration + ($students->currentPage()-1)*$students->perPage() }}</td>
                            <td>{{ $student->student_code }}</td>
                            <td class="text-start">{{ $student->name }}</td>
                            <td class="text-start">{{ $student->email }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->join_from ? \Carbon\Carbon::parse($student->join_from)->format('d M Y') : '-' }}</td>
                            <td>{{ $student->join_to ? \Carbon\Carbon::parse($student->join_to)->format('d M Y') : '-' }}</td>
                            <td>{{ $student->total_days ?? '-' }}</td>
                            <td>₹{{ number_format($student->fee, 2) ?? '-' }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning me-1 shadow-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger shadow-sm" onclick="confirmDelete(this)">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <i class="bi bi-exclamation-circle me-2"></i> No students found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="card-footer d-flex justify-content-center bg-white">
            {{ $students->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(button) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently delete the student!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}

// Success toast
@if(session('success'))
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: {!! json_encode(session('success')) !!},
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
