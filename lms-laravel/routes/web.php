<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\RevenueController;

Route::get('/', function(){
     
    return redirect()->route('login');
});


// Public auth routes
Route::middleware('prevent-back-history')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Forgot Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot.password');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);

    // Reset Password
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('reset.password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// Protected admin routes
Route::middleware('admin')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    // Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    // Books
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/add', [BookController::class, 'create'])->name('books.add');
    Route::post('/books', [BookController::class, 'store'])->name('books.index');
    Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');

 
 
});

Route::prefix('revenue')->name('revenue.')->group(function () {
    Route::get('/', [RevenueController::class, 'index'])->name('index'); // dashboard detail page
});

// Students
Route::prefix('admin')->group(function () {
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/add', [StudentController::class, 'create'])->name('students.add');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
});

// Book Loans
Route::prefix('book-loans')->name('loans.')->group(function () {
    Route::get('/', [LoanController::class, 'index'])->name('index');       // List loans
    Route::get('/add', [LoanController::class, 'create'])->name('add');     // Show add form
    Route::post('/store', [LoanController::class, 'store'])->name('store'); // Save loan
    Route::get('/{loan}/edit', [LoanController::class, 'edit'])->name('edit'); // Edit form
    Route::put('/{loan}', [LoanController::class, 'update'])->name('update');  // Update
    Route::delete('/{loan}', [LoanController::class, 'destroy'])->name('destroy'); // Delete
});

 
Route::prefix('subscriptions')->name('subscriptions.')->group(function() {
    Route::get('/', [SubscriptionController::class, 'index'])->name('index');
    Route::get('/add', [SubscriptionController::class, 'create'])->name('add');
    Route::post('/', [SubscriptionController::class, 'store'])->name('store');
    Route::get('/{subscription}/edit', [SubscriptionController::class, 'edit'])->name('edit');
    Route::put('/{subscription}', [SubscriptionController::class, 'update'])->name('update');
    Route::delete('/{subscription}', [SubscriptionController::class, 'destroy'])->name('destroy');
     
    Route::get('/plans', [SubscriptionController::class, 'plans'])->name('plans');
});

Route::prefix('plans')->name('plans.')->group(function () {
    Route::get('/', [PlanController::class, 'index'])->name('index');   // show plans list
    Route::get('/create', [PlanController::class, 'create'])->name('create'); // 👈 Add plan page
    Route::post('/', [PlanController::class, 'store'])->name('store');
    Route::get('/{plan}/edit', [PlanController::class, 'edit'])->name('edit');
    Route::put('/{plan}', [PlanController::class, 'update'])->name('update');
    Route::delete('/{plan}', [PlanController::class, 'destroy'])->name('destroy');
});
