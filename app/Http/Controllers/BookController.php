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
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
        ]);

        // Cria ou busca o autor digitado
        $author = \App\Models\BookAuthors::firstOrCreate(['description' => $validated['author']]);
        $category = \App\Models\BookCategory::firstOrCreate(['description' => $validated['category']]);
        $language = \App\Models\BookLanguage::firstOrCreate(['description' => $validated['language']]);

        // Cria o livro
        \App\Models\Book::create([
            'title' => $validated['title'],
            'author_id' => $author->id,
            'category_id' => $category->id,
            'language_id' => $language->id,
            'amount' => $validated['amount'],
        ]);

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
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
        ]);
        $author = \App\Models\BookAuthors::firstOrCreate(['description' => $validated['author']]);
        $category = \App\Models\BookCategory::firstOrCreate(['description' => $validated['category']]);
        $language = \App\Models\BookLanguage::firstOrCreate(['description' => $validated['language']]);

        $book->update([
            'title' => $validated['title'],
            'author_id' => $author->id,
            'category_id' => $category->id,
            'language_id' => $language->id,
            'amount' => $validated['amount'],
        ]);

        return redirect()->route('book-management.index')->with('success', 'Livro atualizado com sucesso!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('book-management.index')->with('success', 'Livro excluído com sucesso!');
    }
}
