@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-12 text-center mb-4">
    <h3 class="text-light">📧 Forgot Password</h3>
  </div>

  <div class="col-md-10">
    @if(session('error'))
      <div class="alert alert-danger bg-danger text-white border-0">{{ session('error') }}</div>
    @endif
    @if(session('success'))
      <div class="alert alert-success bg-success text-white border-0">{{ session('success') }}</div>
    @endif

    <form method="POST" action="/forgot-password">
      @csrf
      <div class="mb-3">
        <label class="form-label text-light">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <button class="btn btn-primary w-100">Send Reset Link</button>
    </form>
  </div>
</div>
@endsection
