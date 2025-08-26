<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Loan;

class RevenueController extends Controller
{
    public function index()
    {
        // Total fee paid by students
        $students = Student::select('name', 'fee')->get();

        // Total late fee from loans
        $loans = Loan::with('student', 'book')
                     ->where('late_fee', '>', 0)
                     ->get();

        return view('admin.revenue.index', compact('students', 'loans'));
    }
}
