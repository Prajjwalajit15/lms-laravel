<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student_code', 'name', 'email', 'course', 'phone', 'address',
        'join_from', 'join_to', 'total_days', 'fee'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            $lastStudent = Student::orderBy('id', 'desc')->first();
            $nextCode = !$lastStudent ? 1 : ((int) filter_var($lastStudent->student_code, FILTER_SANITIZE_NUMBER_INT)) + 1;
            $student->student_code = 'STU' . str_pad($nextCode, 3, '0', STR_PAD_LEFT);
        });
    }
}

