<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use App\Models\Student;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the loans.
     */
    public function index(Request $request)
    {
        $query = Loan::with(['book', 'student']);

        // Search filter
        if ($search = $request->get('q')) {
            $query->whereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            })
            ->orWhereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })
            ->orWhere('status', 'like', "%$search%");
        }

        $loans = $query->latest()->paginate(10);

        return view('admin.loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new loan.
     */
    public function create()
    {
        $books = Book::all();
        $students = Student::all();
        return view('admin.loans.create', compact('books', 'students'));
    }

    /**
     * Store a newly created loan.
     */
 public function store(Request $request)
{
    $request->validate([
        'book_id'    => 'required|exists:books,id',
        'student_id' => 'required|exists:students,id',
        'loan_date'  => 'required|date',
        'return_date'=> 'required|date|after_or_equal:loan_date',
    ]);

    // ✅ Restrict student to max 3 active loans
    $activeLoansCount = Loan::where('student_id', $request->student_id)
        ->where('status', 'active')
        ->count();

    if ($activeLoansCount >= 3) {
        return redirect()->back()
            ->withInput()
            ->with('loan_limit_warning', 'This student already has 3 active loans. Cannot issue more books.');
    }

    Loan::create([
        'book_id'    => $request->book_id,
        'student_id' => $request->student_id,
        'loan_date'  => $request->loan_date,
        'return_date'=> $request->return_date,
        'status'     => 'active',
        'late_fee'   => 0,
    ]);

    return redirect()->route('loans.index')->with('success', 'Borrowed book record created successfully.');
}



    /**
     * Show the form for editing a loan.
     */
    public function edit($id)
    {
        $loan = Loan::findOrFail($id);
        $books = Book::all();
        $students = Student::all();

        return view('admin.loans.edit', compact('loan', 'books', 'students'));
    }

    /**
     * Update a loan.
     */
public function update(Request $request, $id)
{
    $loan = Loan::findOrFail($id);

    $request->validate([
        'book_id'            => 'required|exists:books,id',
        'student_id'         => 'required|exists:students,id',
        'loan_date'          => 'required|date',
        'return_date'        => 'required|date|after_or_equal:loan_date',
        'actual_return_date' => 'nullable|date|after_or_equal:loan_date',
        'status'             => 'required|in:active,returned',
    ]);

    // ❌ Prevent marking as returned without actual return date
    if ($request->status === 'returned' && !$request->actual_return_date) {
        return redirect()->back()
            ->withInput()
            ->with('loan_error', 'You must set the Actual Return Date before marking as Returned.');
    }

    // ❌ Prevent re-activating a returned loan
    if ($loan->status === 'returned' || $loan->actual_return_date) {
        if ($request->status === 'active') {
            return redirect()->back()
                ->withInput()
                ->with('loan_error', 'This book has already been returned and cannot be marked active again.');
        }
    }

    // ✅ Calculate late fee if returned
    $lateFee = 0;
    if ($request->actual_return_date) {
        $expectedReturn = \Carbon\Carbon::parse($request->return_date);
        $actualReturn   = \Carbon\Carbon::parse($request->actual_return_date);

        if ($actualReturn->gt($expectedReturn)) {
            $daysLate = $expectedReturn->diffInDays($actualReturn);
            $lateFee  = $daysLate * 10; // ₹10 per day
        }
    }

    $loan->update([
        'book_id'            => $loan->book_id, // ✅ keep original book, not editable
        'student_id'         => $request->student_id,
        'loan_date'          => $request->loan_date,
        'return_date'        => $request->return_date,
        'actual_return_date' => $request->actual_return_date,
        'status'             => $request->status,
        'late_fee'           => $lateFee,
    ]);

    return redirect()->route('loans.index')->with('success', 'Borrowed book updated successfully.');
}




    /**
     * Remove a loan.
     */
    public function destroy($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'borrowed book deleted successfully.');
    }
}
