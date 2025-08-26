@extends('layouts.app')

@section('content')
<div class="container mt-5">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0"><i class="bi bi-journal-text me-2"></i> Borrowed Books</h1>
    <a href="{{ route('loans.add') }}" class="btn btn-primary">
      <i class="bi bi-plus-lg me-1"></i> New Borrowed Books
    </a>
  </div> 
  
  <!-- 🔍 Search Form -->
  <div class="mb-4">
    <form class="search-form d-flex" role="search" method="GET" action="{{ route('loans.index') }}">
      <div class="input-group">
        <input class="form-control shadow-sm" 
               type="search" 
               name="q" 
               placeholder="Search by book, student, or status..." 
               value="{{ request('q') }}">
        <button class="btn btn-primary px-4" type="submit"><i class="bi bi-search"></i></button>
      </div>
    </form>
  </div>

  <!-- Table -->
  <div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-4">
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Book</th>
              <th>Student</th>
              <th>Loan Date</th>
              <th>Return Date</th>
              <th>Status</th>
              <th>Late Fee</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($loans as $loan)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $loan->book->title ?? 'N/A' }}</td>
              <td>{{ $loan->student->name ?? 'N/A' }}</td>
              <td>{{ $loan->loan_date }}</td>
              <td>{{ $loan->return_date }}</td>
              <td>
                <span class="badge 
                  {{ $loan->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                  {{ ucfirst($loan->status) }}
                </span>
              </td>
              <td>₹{{ $loan->late_fee ?? 0 }}</td>
              <td>
                <a href="{{ route('loans.edit', $loan->id) }}" class="btn btn-sm btn-warning me-1">
                  <i class="bi bi-pencil-square"></i> Edit
                </a>
                <form action="{{ route('loans.destroy', $loan->id) }}" method="POST" class="d-inline delete-form">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger" type="button" onclick="confirmDelete(this)">
                    <i class="bi bi-trash"></i> Delete
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center text-muted">No loans found.</td>
            </tr>
            @endforelse
          </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3">
          {{ $loans->withQueryString()->links() }}
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Delete confirmation
    window.confirmDelete = function (button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the borrowed books record!",
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

    // ✅ Success Toast
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

    // ⚠️ No record notification
    @if($loans->isEmpty())
    Swal.fire({
        icon: 'warning',
        title: 'No borrowed books found',
        text: 'Try adjusting your search or add a new loan.',
        confirmButtonText: 'OK'
    });
    @endif
});
</script>
@endpush
