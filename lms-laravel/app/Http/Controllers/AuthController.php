<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Book;
use App\Models\Student;
use App\Models\Loan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Show login form
    public function showLogin() {
        if (session()->has('admin_id')) {
            return redirect('/dashboard'); // already logged in → go to dashboard
        }
        return view('auth.login');
    }

   // Handle login
public function login(Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $admin = Admin::where('email', $request->email)->first();

    if ($admin && Hash::check($request->password, $admin->password)) {
        Session::put('admin_id', $admin->id);
        Session::put('admin_name', $admin->name);
        Session::put('admin_email', $admin->email);

        // ✅ SweetAlert flash
        return redirect('/dashboard')->with('success', 'Welcome back, ' . $admin->name . '!');
    }
    return back()->with('error', 'Invalid login credentials!');
}

// Logout
public function logout() {
    Session::forget(['admin_id', 'admin_name', 'admin_email']);

    // ✅ SweetAlert flash
    return redirect('/login')->with('success', 'You have logged out successfully.');
}


    // Show forgot password form
    public function showForgotPassword() {
        return view('auth.forgot');
    }

    // Handle forgot password request
    public function sendResetLink(Request $request) {
        $request->validate(['email' => 'required|email']);

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return back()->with('error', 'Email not found!');
        }

        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        return redirect()->route('reset.password', ['token' => $token])
                         ->with('success', 'Please reset your password below.');
    }

    // Show reset password form
    public function showResetPassword($token) {
        return view('auth.reset', compact('token'));
    }

    // Handle reset password
    public function resetPassword(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->with('error', 'Invalid or expired reset token!');
        }

        Admin::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Password reset successfully!');
    }

public function dashboard() {
    $totalBooks = Book::count();
    $totalStudents = Student::count();
    $totalBorrowed = Loan::where('status', 'active')->count();
    $totalStudentFees = Student::sum('fee'); // sum of all student fees
    $totalLateFees    = Loan::sum('late_fee'); // sum of all late fees
    $totalRevenue     = $totalStudentFees + $totalLateFees; // total revenue

    // Recent entries
    $recentStudents = Student::latest()->take(5)->get();
    $recentLoans = Loan::with(['book', 'student'])
                        ->latest()
                        ->take(5)
                        ->get();
    $recentBooks = Book::latest()->take(5)->get(); // New Books

    return view('admin.dashboard', compact(
        'totalBooks',
        'totalStudents',
        'totalBorrowed',
        'totalStudentFees',
        'totalLateFees',
        'totalRevenue',
        'recentStudents',
        'recentLoans',
        'recentBooks'
    ));
}


}
