@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header text-center">
          <h4 class="mb-0">Edit Book</h4>
        </div>
        <div class="card-body p-4">
          <form action="{{ route('books.update', $book->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Book Code</label>
                <input type="text" name="book_code" class="form-control" 
                       value="{{ old('book_code', $book->book_code) }}" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Title</label>
                <input type="text" name="title" class="form-control" 
                       value="{{ old('title', $book->title) }}">
              </div>
            </div>

            <div class="row g-3 mt-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Author</label>
                <input type="text" name="author" class="form-control" 
                       value="{{ old('author', $book->author) }}">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Category</label>
                <select name="category" class="form-select">
                  <option disabled>Select category</option>
                  <option value="Fiction" {{ old('category', $book->category) == 'Fiction' ? 'selected' : '' }}>Fiction</option>
                  <option value="Non-fiction" {{ old('category', $book->category) == 'Non-fiction' ? 'selected' : '' }}>Non-fiction</option>
                  <option value="Science" {{ old('category', $book->category) == 'Science' ? 'selected' : '' }}>Science</option>
                  <option value="History" {{ old('category', $book->category) == 'History' ? 'selected' : '' }}>History</option>
                </select>
              </div>
            </div>

            <!-- New Status Field -->
            <div class="row g-3 mt-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="Available" {{ old('status', $book->status) == 'Available' ? 'selected' : '' }}>Available</option>
                    <option value="Borrowed" {{ old('status', $book->status) == 'Borrowed' ? 'selected' : '' }}>Borrowed</option>
                    <option value="Not Available" {{ old('status', $book->status) == 'Not Available' ? 'selected' : '' }}>Not Available</option>
                </select>
              </div>
            </div>

            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-save me-2"></i> Update Book
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        confirmButtonColor: '#d33'
    });
</script>
@endif
@endpush
