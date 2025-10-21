<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\UsersBooks;
use App\Models\UsersBookStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UsersBookController extends Controller
{
    // Listar todos os empréstimos (usuário logado)
    public function index()
    {
        $user = Auth::user();
        $loans = UsersBooks::with(['book', 'status'])
            ->where('user_id', $user->id)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('loans.index', compact('loans'));
    }

    // Mostrar formulário de empréstimo
    public function create()
    {
        $books = Book::where('amount', '>', 0)->get();
        return view('loans.create', compact('books'));
    }

    // Registrar novo empréstimo
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $user = Auth::user();

        // Verifica limite de 2 livros emprestados
        $activeLoans = UsersBooks::where('user_id', $user->id)
            ->whereHas('status', fn($q) => $q->where('description', 'Emprestado'))
            ->count();

        if ($activeLoans >= 2) {
            return back()->with('error', 'Você já possui 2 livros emprestados.');
        }

        $book = Book::findOrFail($request->book_id);

        if ($book->amount <= 0) {
            return back()->with('error', 'Não há estoque disponível para este livro.');
        }

        // Reduz estoque
        $book->decrement('amount');

        // Cria empréstimo
        UsersBooks::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status_id' => UsersBookStatus::where('description', 'Emprestado')->first()->id,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(7),
        ]);

        return redirect()->route('loans.index')->with('success', 'Livro emprestado com sucesso!');
    }

    // Devolver livro
    public function devolver($id)
    {
        $loan = UsersBooks::findOrFail($id);

        if ($loan->status->description === 'Devolvido') {
            return back()->with('info', 'Este livro já foi devolvido.');
        }

        $loan->update([
            'status_id' => UsersBookStatus::where('description', 'Devolvido')->first()->id,
        ]);

        // Aumenta estoque
        $loan->book->increment('amount');

        return back()->with('success', 'Livro devolvido com sucesso!');
    }

    // Listar atrasados
    public function atrasados()
    {
        $today = Carbon::now();

        $overdue = UsersBooks::with(['book', 'user'])
            ->whereHas('status', fn($q) => $q->where('description', 'Emprestado'))
            ->where('end_date', '<', $today)
            ->get();

        return view('loans.overdue', compact('overdue'));
    }
}
