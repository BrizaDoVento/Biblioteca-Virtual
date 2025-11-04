<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookAuthors;

class BookController extends Controller
{
    /**
     * Exibe a lista de todos os livros cadastrados.
     */
    public function index()
    {
        $books = Book::orderBy('title', 'asc')->get();
        return view('books.index', compact('books'));
    }

    /**
     * Exibe o formulário de criação de um novo livro.
     */
    public function create()
    {
        $autor = BookAuthors::all();
        return view('books.create', compact('autor'));
    }

    /**
     * Armazena um novo livro no banco de dados.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|integer|min:0',
        ]);

        $validated['status'] = 'disponível';

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Livro cadastrado com sucesso!');
    }

    /**
     * Exibe o formulário de edição de um livro.
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    /**
     * Atualiza os dados de um livro existente.
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|integer|min:0',
        ]);

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso!');
    }

    /**
     * Remove um livro do sistema.
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Livro não encontrado.');
        }

        // Verifica se o livro está emprestado
        if ($book->status === 'emprestado') {
            return redirect()->route('books.index')->with('error', 'Não é possível excluir um livro emprestado.');
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso!');
    }
}
