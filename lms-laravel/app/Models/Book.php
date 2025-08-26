<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // Table name (optional if using 'books')
    protected $table = 'books';

    // Fields that are mass assignable
    protected $fillable = [
        'book_code',
        'title',
        'author',
        'category',
        'status', // optional, if you have a status column
    ];
}
