<?php

namespace App\Http\Controllers; 
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
{
    $query = Student::query();

    if ($request->has('q') && !empty($request->q)) {
        $search = $request->q;

        $query->where(function ($q) use ($search) {
            $q->where('student_code', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    $students = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

    return view('admin.students.index', compact('students'));
}


    public function create()
{
    // Get last student entry
    $lastStudent = \App\Models\Student::latest('id')->first();

    // Generate next student code (e.g., STU-0001, STU-0002, etc.)
    $nextId = $lastStudent ? $lastStudent->id + 1 : 1;
    $studentCode = 'STU-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

    // Pass studentCode to the view
    return view('admin.students.add', compact('studentCode'));
}


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:students',
        'course' => 'required|string',
        'phone' => 'required|string',
        'address' => 'nullable|string',
        'join_from' => 'required|date',
        'join_to' => 'required|date|after_or_equal:join_from',
        'total_days' => 'required|integer|min:1',
        'fee' => 'required|numeric|min:0',
    ]);

    Student::create($request->all());

    return redirect()->route('students.index')->with('success', 'Student added successfully!');
}

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }
 

public function update(Request $request, $id)
{
    $student = Student::findOrFail($id);

    $request->validate([
        'student_code' => [
            'required',
            Rule::unique('students', 'student_code')->ignore($student->id),
        ],
        'name'       => 'required|string|max:255',
        'email'      => [
            'required',
            'email',
            Rule::unique('students', 'email')->ignore($student->id),
        ],
        'course'     => 'required|string|max:255',
        'phone'      => 'required|string|max:15',
        'address'    => 'nullable|string',
        'join_from'  => 'required|date',
        'join_to'    => 'required|date|after_or_equal:join_from',
        'total_days' => 'required|integer|min:1',
        'fee'        => 'required|numeric|min:0',
    ]);

    $student->update($request->all());

    return redirect()->route('students.index')
        ->with('success', 'Student updated successfully!');
}



    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}

