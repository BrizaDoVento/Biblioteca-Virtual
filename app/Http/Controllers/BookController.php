<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookAuthors;
use App\Models\BookCategory;
use App\Models\BookLanguage;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'category', 'language'])->get();
        return view('book-management.index', compact('books'));
    }

    public function create()
    {
        $authors = BookAuthors::all();
        $categories = BookCategory::all();
        $languages = BookLanguage::all();

        return view('book-management.create', compact('authors', 'categories', 'languages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:book_authors,id',
            'category_id' => 'required|exists:book_categories,id',
            'language_id' => 'required|exists:book_languages,id',
            'amount' => 'required|integer|min:1',
        ]);

        Book::create($validated);

        return redirect()->route('book-management.index')->with('success', 'Livro cadastrado com sucesso!');
    }

    public function edit(Book $book)
    {
        $authors = BookAuthors::all();
        $categories = BookCategory::all();
        $languages = BookLanguage::all();

        return view('book-management.edit', compact('book', 'authors', 'categories', 'languages'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:book_authors,id',
            'category_id' => 'required|exists:book_categories,id',
            'language_id' => 'required|exists:book_languages,id',
            'amount' => 'required|integer|min:1',
        ]);

        $book->update($validated);

        return redirect()->route('book-management.index')->with('success', 'Livro atualizado com sucesso!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('book-management.index')->with('success', 'Livro excluído com sucesso!');
    }
}
