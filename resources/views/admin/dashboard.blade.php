@extends('layouts.app')
@section('content')
<!-- Main content start -->
<main class="mt-1 pt-3" style="background-color: #f8f9fa; min-height: 100vh;">
            <div class="container-fluid">
                <!-- Dashboard Heading -->
                <div class="row dashboard-counts text-dark">
                    <div class="col-md-12 m-2">
                        <h4 class="fs-2 fw-bold text-uppercase">Dashboard</h4>
                        <p>Statistics of the system!</p>
                    </div>
                </div>

        <!-- Cards Carousel -->
                <div id="dashboardCardsCarousel" class="carousel slide">
                    <div class="carousel-inner">

                        <!-- Slide 1 -->
                        <div class="carousel-item active">
                            <div class="row justify-content-center">
                                <!-- Total Books -->
                                <div class="col-md-3 d-flex">
                                    <div class="card text-center shadow-sm flex-fill d-flex flex-column">
                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <h6 class="card-title text-uppercase text-muted">Total Books</h6>
                                            <h1 class="my-2">{{ $totalBooks }}</h1>
                                            <canvas id="booksChart" height="120"></canvas>
                                            <a href="{{ route('books.index') }}" class="card-link link-underline-light mt-3">View more</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Students -->
                                <div class="col-md-3 d-flex">
                                    <div class="card text-center shadow-sm flex-fill d-flex flex-column">
                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <h6 class="card-title text-uppercase text-muted">Total Students</h6>
                                            <h1 class="my-2">{{ $totalStudents }}</h1>
                                            <canvas id="studentsChart" height="120"></canvas>
                                            <a href="{{ route('students.index') }}" class="card-link link-underline-light mt-3">View more</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- borrowed books -->
                                <div class="col-md-3 d-flex">
                                    <div class="card text-center shadow-sm flex-fill d-flex flex-column">
                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <h6 class="card-title text-uppercase text-muted">Borrowed books</h6>
                                            <h1 class="my-2">{{ $totalBorrowed }}</h1>
                                            <canvas id="loansChart" height="120"></canvas>
                                            <a href="{{ route('loans.index') }}" class="card-link link-underline-light mt-3">View more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="carousel-item">
                            <div class="row justify-content-center">
                                <!-- Total Books (repeat if needed) -->
                                <div class="col-md-3 d-flex">
                                    <div class="card text-center shadow-sm flex-fill d-flex flex-column">
                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <h6 class="card-title text-uppercase text-muted">Total Books</h6>
                                            <h1 class="my-2">{{ $totalBooks }}</h1>
                                            <canvas id="booksChart2" height="120"></canvas>
                                            <a href="{{ route('books.index') }}" class="card-link link-underline-light mt-3">View more</a>
                                        </div>
                                    </div>
                                </div>

                            <!-- Total Revenue -->
                                <div class="col-md-3 d-flex">
                                    <div class="card text-center shadow-sm flex-fill d-flex flex-column">
                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <h6 class="card-title text-uppercase text-muted">Total Revenue</h6>
                                            <h1 class="my-2">₹{{ number_format($totalRevenue) }}</h1>
                                            <canvas id="revenueChart" height="120"></canvas>
                                            <a href="{{ route('revenue.index') }}" class="card-link link-underline-light mt-3">View more</a>
                
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#dashboardCardsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#dashboardCardsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
                    </button>
                </div>


<!-- Tabs -->
            <div class="row mt-5 dashboard-tabs">
                <div class="col-md-12">
                    <!-- Tabs Nav -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active text-uppercase text-dark" id="recent-students-tab" data-bs-toggle="tab"
                                data-bs-target="#recent-students-pane" type="button" role="tab">New Students</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link text-uppercase text-dark" id="recent-loan-tab" data-bs-toggle="tab"
                                data-bs-target="#recent-loan-pane" type="button" role="tab">Borrowed Books</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link text-uppercase text-dark" id="recent-books-tab" data-bs-toggle="tab"
                                data-bs-target="#recent-books-pane" type="button" role="tab">New Books</button>
                        </li>
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content p-3 border border-light rounded-bottom shadow-sm" id="myTabContent">
                        
                        <!-- Students -->
                        <div class="tab-pane fade show active" id="recent-students-pane">
                            <table class="table table-hover table-striped align-middle mt-3 table-bordered table-light">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Preparing For</th>
                                        <th>Joining From</th>
                                        <th>Joining To</th>
                                        <th>Total Days</th>
                                        <th>Fee (₹)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentStudents as $student)
                                        @php
                                            $joinFrom = \Carbon\Carbon::parse($student->join_from);
                                            $joinTo   = \Carbon\Carbon::parse($student->join_to);
                                            $totalDays = $joinFrom->diffInDays($joinTo) + 1;
                                            $perDayFee = 100;
                                            $fee = $totalDays * $perDayFee;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->course }}</td>
                                            <td>{{ $joinFrom->format('d-m-Y') }}</td>
                                            <td>{{ $joinTo->format('d-m-Y') }}</td>
                                            <td>{{ $totalDays }}</td>
                                            <td>₹{{ number_format($fee, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No students found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Borrowed Books -->
                        <div class="tab-pane fade" id="recent-loan-pane">
                            <table class="table table-hover table-striped align-middle mt-3 table-bordered table-light">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>#</th>
                                        <th>Book</th>
                                        <th>Student</th>
                                        <th>Loan Date</th>
                                        <th>Return Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentLoans as $loan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $loan->book->title ?? 'N/A' }}</td>
                                        <td>{{ $loan->student->name ?? 'N/A' }}</td>
                                        <td>{{ $loan->loan_date }}</td>
                                        <td>{{ $loan->return_date }}</td>
                                        <td>
                                            <span class="badge {{ $loan->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($loan->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No borrowed books found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- New Books -->
                        <div class="tab-pane fade" id="recent-books-pane">
                            <table class="table table-hover table-striped align-middle mt-3 table-bordered table-light">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>Added On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentBooks as $book)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->author }}</td>
                                        <td>{{ $book->category }}</td>
                                        <td>{{ $book->created_at->format('d-m-Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No books found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

                <style>
                /* Light theme adjustments */
                .nav-tabs .nav-link.active {
                    background-color: #ffffff !important;
                    border-color: #dee2e6 #dee2e6 #fff !important;
                }
                .nav-tabs .nav-link {
                    border: 1px solid #dee2e6;
                    border-bottom: none;
                    margin-right: 2px;
                    background-color: #f8f9fa;
                    color: #495057;
                }
                .nav-tabs .nav-link:hover {
                    background-color: #e9ecef;
                    color: #495057;
                }
                .table-hover tbody tr:hover {
                    background-color: #f1f3f5;
                }
                </style>



        </div>
</main>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Example Chart Instances
    new Chart(document.getElementById("booksChart"), {
        type: "doughnut",
        data: { labels: ["Issued", "Available"], datasets: [{ data: [45, 75], backgroundColor: ["#0d6efd", "#6c757d"] }] },
        options: { plugins: { legend: { display: false } } }
    });

    new Chart(document.getElementById("studentsChart"), {
        type: "bar",
        data: { labels: ["2021", "2022", "2023"], datasets: [{ label: "Students", data: [200, 280, 340], backgroundColor: "#0d6efd" }] },
        options: { plugins: { legend: { display: false } } }
    });

    new Chart(document.getElementById("loansChart"), {
        type: "line",
        data: { labels: ["Jan", "Feb", "Mar"], datasets: [{ label: "Loans", data: [30, 50, 85], borderColor: "#0d6efd", fill: false }] },
        options: { plugins: { legend: { display: false } } }
    });

    new Chart(document.getElementById("revenueChart"), {
        type: "bar",
        data: { labels: ["Jan", "Feb", "Mar"], datasets: [{ label: "Revenue", data: [30000, 40000, 50000], backgroundColor: "#ffc107" }] },
        options: { plugins: { legend: { display: false } } }
    });

    new Chart(document.getElementById("booksChart2"), {
        type: "doughnut",
        data: { labels: ["Issued", "Available"], datasets: [{ data: [45, 75], backgroundColor: ["#0d6efd", "#6c757d"] }] },
        options: { plugins: { legend: { display: false } } }
    });

    // Disable auto-slide for carousel
    var dashboardCarousel = document.getElementById('dashboardCardsCarousel');
    var carousel = new bootstrap.Carousel(dashboardCarousel, {
        interval: false,
        ride: false
    });
</script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: "{{ session('success') }}",
        background: '#ffffff',
        color: '#333',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        toast: true,
        position: 'top-end',
        showClass: {
            popup: 'animate__animated animate__fadeInRight'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutRight'
        }
    });
</script>
@endif




@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ session('error') }}",
        confirmButtonColor: "#d33"
    });
</script>
@endif

@endsection

