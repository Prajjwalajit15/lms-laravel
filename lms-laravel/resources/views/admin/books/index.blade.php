@extends('layouts.app')

@section('content')
<div class="container mt-5">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0"><i class="bi bi-book me-2"></i>View Books</h1>
    <a href="{{ route('books.add') }}" class="btn btn-primary">
      <i class="bi bi-plus-lg me-1"></i> Add Book
    </a>
  </div> 
  
 
 <!-- 🔍 Search Form -->
<div class="mb-4">
  <form class="search-form d-flex" role="search" method="GET" action="{{ route('books.index') }}">
    <div class="input-group">
      <input class="form-control shadow-sm" 
             type="search" 
             name="q" 
             placeholder="Search by code, title, author, category, or status..." 
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
            <th>Book Code</th>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($books as $book)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $book->book_code }}</td>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->category }}</td>
            <td>
              <span class="badge 
                {{ $book->status == 'Available' ? 'bg-success' : ($book->status == 'Borrowed' ? 'bg-warning' : 'bg-danger') }}">
                {{ $book->status }}
              </span>
            </td>
            <td>
              <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning me-1">
                <i class="bi bi-pencil-square"></i> Edit
              </a>
              <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline delete-form">
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
            <td colspan="7" class="text-center text-muted">No books found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="mt-3">
        {{ $books->withQueryString()->links() }}
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
            text: "This will permanently delete the book!",
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

    // Success message
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
    showClass: {
        popup: 'animate__animated animate__fadeInRight'
    },
    hideClass: {
        popup: 'animate__animated animate__fadeOutRight'
    }
});
@endif

       // ⚠️ No record notification
    @if($books->isEmpty())
    Swal.fire({
        icon: 'warning',
        title: 'No books found',
        text: 'Try adjusting your search or add a new book.',
        confirmButtonText: 'OK'
    });
    @endif

});
</script>
@endpush


