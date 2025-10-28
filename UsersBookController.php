<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\UsersBooks;
use App\Models\UsersBookStatus;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UsersBookController extends Controller
{
    public function index()
    {
        $emprestimos = UsersBooks::with(['book', 'status'])->get();
        return view('loans.index', compact('emprestimos'));
    }

    public function create()
    {
        $books = Book::where('amount', '>', 0)->get();
        return view('loans.create', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate(['book_id' => 'required|exists:books,id']);

        $userId = 1; // substituir por auth()->id() se usar autenticação
        $emprestimosAtivos = UsersBooks::where('user_id', $userId)
            ->whereHas('status', fn($q) => $q->where('description', 'Emprestado'))
            ->count();

        if ($emprestimosAtivos >= 2) {
            return back()->withErrors('Você já possui 2 livros emprestados.');
        }

        $book = Book::find($request->book_id);
        if ($book->amount <= 0) {
            return back()->withErrors('Este livro não está disponível.');
        }

        $statusEmprestado = UsersBookStatus::where('description', 'Emprestado')->first();

        UsersBooks::create([
            'user_id' => $userId,
            'book_id' => $book->id,
            'status_id' => $statusEmprestado->id,
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ]);

        $book->decrement('amount');

        return redirect()->route('loans.index')->with('success', 'Empréstimo realizado com sucesso!');
    }

    public function devolver($id)
    {
        $emprestimo = UsersBooks::findOrFail($id);
        $statusDevolvido = UsersBookStatus::where('description', 'Devolvido')->first();

        $emprestimo->update(['status_id' => $statusDevolvido->id]);
        $emprestimo->book->increment('amount');

        return redirect()->route('loans.index')->with('success', 'Livro devolvido com sucesso!');
    }

    public function atrasados()
    {
        $atrasados = UsersBooks::with(['book', 'status'])
            ->whereDate('end_date', '<', Carbon::today())
            ->whereHas('status', fn($q) => $q->where('description', 'Emprestado'))
            ->get();

        return view('loans.atrasados', compact('atrasados'));
    }
}
