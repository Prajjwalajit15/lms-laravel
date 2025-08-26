@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header text-center">
          <h4 class="mb-0"><i class="bi bi-book me-2"></i> Add New Book</h4>
        </div>
        <div class="card-body p-4">
          <form action="{{ route('books.index') }}" method="POST">
            @csrf

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Book Code</label>
                <input type="text" name="book_code" class="form-control" 
                      value="{{ $bookCode ?? old('book_code') }}" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Title</label>
                <input type="text" name="title" 
                       class="form-control @error('title') is-invalid @enderror" 
                       value="{{ old('title') }}" placeholder="Enter book title">
                @error('title')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Author</label>
                <input type="text" name="author" 
                       class="form-control @error('author') is-invalid @enderror" 
                       value="{{ old('author') }}" placeholder="Enter author name">
                @error('author')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Category</label>
                <select name="category" 
                        class="form-select @error('category') is-invalid @enderror">
                  <option selected disabled>Select category</option>
                  <option value="Fiction" {{ old('category') == 'Fiction' ? 'selected' : '' }}>Fiction</option>
                  <option value="Non-fiction" {{ old('category') == 'Non-fiction' ? 'selected' : '' }}>Non-fiction</option>
                  <option value="Science" {{ old('category') == 'Science' ? 'selected' : '' }}>Science</option>
                  <option value="History" {{ old('category') == 'History' ? 'selected' : '' }}>History</option>
                </select>
                @error('category')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-save me-2"></i> Save Book
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

