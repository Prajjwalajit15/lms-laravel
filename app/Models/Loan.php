<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'student_id',
        'loan_date',
        'return_date',
        'status',
        'late_fee',
    ];

    // A loan belongs to a book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // A loan belongs to a student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
