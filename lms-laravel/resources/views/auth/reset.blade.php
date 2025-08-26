@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-12 text-center mb-4">
    <h3 class="text-light">🔑 Reset Password</h3>
  </div>

  <div class="col-md-10">
    @if(session('error'))
      <div class="alert alert-danger bg-danger text-white border-0">{{ session('error') }}</div>
    @endif
    @if(session('success'))
      <div class="alert alert-success bg-secondary text-white border-0">{{ session('success') }}</div>
    @endif

    <form method="POST" action="/reset-password">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      <div class="mb-3">
        <label class="form-label text-light">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label text-light">New Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label text-light">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
      </div>

      <button class="btn btn-success w-100">Reset Password</button>
    </form>
  </div>
</div>
@endsection
