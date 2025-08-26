@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-light text-center">
          <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Edit Student</h4>
        </div>
        <div class="card-body p-4">
          <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Student Code</label>
                <input type="text" name="student_code" class="form-control" 
                       value="{{ old('student_code', $student->student_code) }}" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Name</label>
                <input type="text" name="name" class="form-control" 
                       value="{{ old('name', $student->name) }}" >
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" 
                       value="{{ old('email', $student->email) }}">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Course</label>
                <input type="text" name="course" class="form-control" 
                       value="{{ old('course', $student->course) }}">
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Phone Number</label>
                <input type="text" name="phone" class="form-control" 
                       value="{{ old('phone', $student->phone) }}">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Fee</label>
                <input type="number" step="0.01" name="fee" class="form-control" 
                       value="{{ old('fee', $student->fee) }}" placeholder="Enter fee amount">
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Joining From</label>
                <input type="date" name="join_from" id="join_from" class="form-control" 
                       value="{{ old('join_from', $student->join_from) }}">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Joining To</label>
                <input type="date" name="join_to" id="join_to" class="form-control" 
                       value="{{ old('join_to', $student->join_to) }}">
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Total Days</label>
                <input type="number" name="total_days" id="total_days" class="form-control" 
                       value="{{ old('total_days', $student->total_days) }}" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Address</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address', $student->address) }}</textarea>
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-md-6 d-grid">
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-save me-2"></i> Update Student
                </button>
              </div>
              <div class="col-md-6 d-grid">
                <a href="javascript:void(0)" class="btn btn-secondary" id="cancel-btn">
                  <i class="bi bi-x-circle me-2"></i> Cancel
                </a>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- SweetAlert for Cancel --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('cancel-btn').addEventListener('click', function(e) {
  e.preventDefault();
  Swal.fire({
    title: 'Are you sure?',
    text: "Any unsaved changes will be lost if you leave this page.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, go back',
    cancelButtonText: 'Stay here'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "{{ route('students.index') }}";
    }
  });
});

// Auto-calculate total days
const joinFrom = document.getElementById("join_from");
const joinTo = document.getElementById("join_to");
const totalDays = document.getElementById("total_days");

// Auto-calculate total days with validation
function calculateDays() {
  if (joinFrom.value && joinTo.value) {
    const start = new Date(joinFrom.value);
    const end = new Date(joinTo.value);

    // Validate that end date is not earlier than start date
    if (end < start) {
      Swal.fire({
        icon: 'error',
        title: 'Invalid Date Selection',
        text: '"Joining To" date cannot be earlier than "Joining From" date.',
        confirmButtonText: 'OK'
      });
      joinTo.value = '';  // reset invalid date
      totalDays.value = '';
      return;
    }

    const diffTime = end - start;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
    totalDays.value = diffDays;
  } else {
    totalDays.value = '';
  }
}

joinFrom.addEventListener("change", calculateDays);
joinTo.addEventListener("change", calculateDays);

// Run initially in case the form has pre-filled dates
calculateDays();

@if ($errors->any()) 
    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        confirmButtonColor: '#d33'
    }); 
@endif

</script>
@endsection


