<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('title')->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'author'     => 'required|string|max:255',
            'category'   => 'required|string|max:255',
            'language'   => 'required|string|max:255',
            'amount'     => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096'
        ]);

        // Upload da imagem
        $imagePath = null;

        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('covers', 'public');
        }

        Book::create([
            'title'       => $request->title,
            'author'      => $request->author,
            'category'    => $request->category,
            'language'    => $request->language,
            'amount'      => $request->amount,
            'cover_image' => $imagePath,
        ]);

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso!');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'author'     => 'required|string|max:255',
            'category'   => 'required|string|max:255',
            'language'   => 'required|string|max:255',
            'amount'     => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096'
        ]);

        // Caso clique em "Remover imagem"
        if ($request->remove_image == "1") {
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $book->cover_image = null;
        }

        // Nova imagem substituindo a anterior
        if ($request->hasFile('cover_image')) {
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $book->cover_image = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update([
            'title'    => $request->title,
            'author'   => $request->author,
            'category' => $request->category,
            'language' => $request->language,
            'amount'   => $request->amount,
        ]);

        $book->save();

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso!');
    }

    public function destroy(Book $book)
    {
        // remover imagem
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso!');
    }
}
