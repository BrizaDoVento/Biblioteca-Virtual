<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Listagem de livros
     */
    public function index()
    {
        $books = Book::orderBy('title')->get();
        return view('books.index', compact('books'));
    }

    /**
     * Formulário de criação
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Salvar novo livro
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount'      => 'required|integer|min:1',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $data = $request->all();

        // Upload da imagem (se enviada)
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso!');
    }

    /**
     * Formulário de edição
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    /**
     * Atualizar livro
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount'      => 'required|integer|min:1',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'remove_image' => 'nullable'
        ]);

        $data = $request->all();

        // Remover imagem atual se marcado
        if ($request->filled('remove_image') && $book->image) {
            Storage::disk('public')->delete($book->image);
            $data['image'] = null;
        }

        // Substituir imagem caso nova esteja sendo enviada
        if ($request->hasFile('image')) {

            // Deletar imagem antiga
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }

            $data['image'] = $request->file('image')->store('books', 'public');
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso!');
    }

    /**
     * Remover livro
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // deletar imagem se existir
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso!');
    }
}
