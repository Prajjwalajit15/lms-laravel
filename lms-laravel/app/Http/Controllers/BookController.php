<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
public function index(Request $request)
{
    $query = Book::query();

    if ($request->has('q') && !empty($request->q)) {
        $search = $request->q;

        $query->where(function ($q) use ($search) {
            $q->where('book_code', 'like', "%{$search}%")
              ->orWhere('title', 'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%")
              ->orWhere('category', 'like', "%{$search}%")
              ->orWhere('status', 'like', "%{$search}%");
        });
    }

    $books = $query->orderBy('id', 'desc')->paginate(10);

    return view('admin.books.index', compact('books'));
}


    public function create()
{
    $latestBook = \App\Models\Book::latest()->first();
    $nextId = $latestBook ? $latestBook->id + 1 : 1;
    $bookCode = 'BOOK-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

    return view('admin.books.add', compact('bookCode'));
}


    public function store(Request $request)
{
    $request->validate([
        'title'    => 'required|string|max:255',
        'author'   => 'required|string|max:255',
        'category' => 'required|string',
    ]);

    // ✅ Auto generate Book Code (e.g., BOOK-0001)
    $latestBook = \App\Models\Book::latest()->first();
    $nextId = $latestBook ? $latestBook->id + 1 : 1;
    $bookCode = 'BOOK-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

    Book::create([
        'book_code' => $bookCode,
        'title'     => $request->title,
        'author'    => $request->author,
        'category'  => $request->category,
    ]);

    return redirect()->route('books.index')->with('success', 'Book added successfully.');
}


    public function edit($id) {
        $book = Book::findOrFail($id);
        return view('admin.books.edit', compact('book'));
    }



public function update(Request $request, $id) {
    $request->validate([
        'book_code' => [
            'required',
            Rule::unique('books', 'book_code')->ignore($id),
        ],
        'title'    => 'required|string|max:255',
        'author'   => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'status'   => 'required|in:Available,Borrowed,Not Available',
    ]);

    $book = Book::findOrFail($id);
    $book->update($request->all());

    return redirect()->route('books.index')->with('success', 'Book updated successfully!');
}



    public function destroy($id) {
        Book::findOrFail($id)->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }
}
