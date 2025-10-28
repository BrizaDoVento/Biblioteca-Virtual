<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Exibe a lista de livros cadastrados
     */
    public function index()
    {
        $books = Book::orderBy('title')->get();
        return view('books.index', compact('books'));
    }

    /**
     * Mostra o formulário de criação de um novo livro
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Armazena um novo livro no banco de dados
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->category = $request->category;
        $book->language = $request->language;
        $book->description = $request->description;
        $book->status = 'disponível'; // Padrão ao criar
        $book->save();

        return redirect()->route('books.index')->with('success', 'Livro adicionado com sucesso!');
    }

    /**
     * Mostra o formulário de edição de um livro existente
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    /**
     * Atualiza os dados de um livro
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $book = Book::findOrFail($id);
        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'category' => $request->category,
            'language' => $request->language,
            'description' => $request->description,
        ]);

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso!');
    }

    /**
     * Remove um livro do banco de dados
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Livro não encontrado.');
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso!');
    }
}
