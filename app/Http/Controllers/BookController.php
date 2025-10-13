<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'category', 'language'])->get();

        return view('books.index', compact('books'));
    }
}
