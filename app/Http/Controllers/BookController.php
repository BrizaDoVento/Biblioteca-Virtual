<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookAuthors;
use App\Models\BookCategory;
use App\Models\BookLanguage;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Exibe a lista de livros.
     */
    public function index()
    {
        $books = Book::with(['author', 'category', 'language'])->get();

        return view('book-management.index', compact('books'));
    }

    /**
     * Exibe o formulário de criação de um novo livro.
     */
    public function create()
    {
        return view('book-management.create');
    }

    /**
     * Armazena um novo livro no banco.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'category_name' => 'required|string|max:255',
            'language_name' => 'required|string|max:255',
            'amount' => 'required|integer|min:0',
        ]);

        // 🔹 Cria ou busca o autor
        $author = BookAuthors::firstOrCreate(['name' => $request->author_name]);

        // 🔹 Cria ou busca a categoria
        $category = BookCategory::firstOrCreate(['name' => $request->category_name]);

        // 🔹 Cria ou busca o idioma
        $language = BookLanguage::firstOrCreate(['name' => $request->language_name]);

        // 🔹 Cria o livro
        Book::create([
            'title' => $request->title,
            'author_id' => $author->id,
            'category_id' => $category->id,
            'language_id' => $language->id,
            'amount' => $request->amount,
        ]);

        return redirect()->route('book-management.index')
            ->with('success', 'Livro cadastrado com sucesso!');
    }

    /**
     * Exibe o formulário de edição de um livro.
     */
    public function edit(Book $book)
    {
        $book->load(['author', 'category', 'language']);
        return view('book-management.edit', compact('book'));
    }

    /**
     * Atualiza um livro existente.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'category_name' => 'required|string|max:255',
            'language_name' => 'required|string|max:255',
            'amount' => 'required|integer|min:0',
        ]);

        // 🔹 Atualiza ou cria as relações
        $author = BookAuthors::firstOrCreate(['name' => $request->author_name]);
        $category = BookCategory::firstOrCreate(['name' => $request->category_name]);
        $language = BookLanguage::firstOrCreate(['name' => $request->language_name]);

        // 🔹 Atualiza o livro
        $book->update([
            'title' => $request->title,
            'author_id' => $author->id,
            'category_id' => $category->id,
            'language_id' => $language->id,
            'amount' => $request->amount,
        ]);

        return redirect()->route('book-management.index')
            ->with('success', 'Livro atualizado com sucesso!');
    }

    /**
     * Remove um livro do banco.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('book-management.index')
            ->with('success', 'Livro excluído com sucesso!');
    }
}
