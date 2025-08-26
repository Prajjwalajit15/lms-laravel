@extends('layouts.auth')

@section('content')
  <div class="text-center mb-4">
    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary" 
         style="width: 80px; height: 80px;">
      <i class="bi bi-shield-lock-fill text-white" style="font-size: 40px;"></i>
    </div>
  </div>

  <h4 class="text-center mb-4">Admin Login</h4>

  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <form method="POST" action="/login">
    @csrf
    <div class="mb-3">
      <label class="form-label text-light">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label text-light">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-primary w-100">Login</button>
    <div class="text-center mt-3">
      <a href="{{ route('forgot.password') }}" class="text-light">Forgot Password?</a>
    </div>
  </form>
@endsection
