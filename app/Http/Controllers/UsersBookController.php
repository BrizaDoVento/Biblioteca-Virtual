<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersBooks;
use App\Models\UsersBookStatus;
use App\Models\User;
use App\Models\Book;
use Carbon\Carbon;

class UsersBookController extends Controller
{
    public function index()
    {
        $loans = UsersBooks::with(['book', 'user', 'status'])->orderBy('start_date', 'desc')->get();
        $books = Book::where('amount', '>', 0)->get();
        $users = User::all();

        return view('loans.index', compact('loans', 'books', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        $userId = $request->user_id;
        $book = Book::find($request->book_id);

        // Verifica estoque
        if ($book->amount < 1) {
            return redirect()->back()->with('error', 'Este livro não está disponível no momento.');
        }

        // Verifica se o usuário já tem 2 empréstimos ativos
        $activeLoans = UsersBooks::where('user_id', $userId)
            ->whereHas('status', function ($query) {
                $query->where('description', 'Emprestado');
            })
            ->count();

        if ($activeLoans >= 2) {
            return redirect()->back()->with('error', 'Usuário já possui 2 livros emprestados.');
        }

        // Obtém o status "Emprestado"
        $statusEmprestado = UsersBookStatus::where('description', 'Emprestado')->first();

        if (!$statusEmprestado) {
            return redirect()->back()->with('error', 'Status "Emprestado" não encontrado. Verifique a seeder.');
        }

        // Cria o empréstimo
        UsersBooks::create([
            'user_id' => $userId,
            'book_id' => $book->id,
            'status_id' => $statusEmprestado->id,
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ]);

        // Diminui o estoque
        $book->decrement('amount');

        return redirect()->route('loans.index')->with('success', 'Livro emprestado com sucesso!');
    }

    public function devolver($id)
    {
        $loan = UsersBooks::findOrFail($id);
        $statusDevolvido = UsersBookStatus::where('description', 'Devolvido')->first();

        if (!$statusDevolvido) {
            return redirect()->back()->with('error', 'Status "Devolvido" não encontrado. Verifique a seeder.');
        }

        $loan->update(['status_id' => $statusDevolvido->id]);

        // Devolve ao estoque
        $loan->book->increment('amount');

        return redirect()->route('loans.index')->with('success', 'Livro devolvido com sucesso!');
    }

    public function atrasados()
    {
        $statusEmprestado = UsersBookStatus::where('description', 'Emprestado')->first();

        $overdueLoans = UsersBooks::with(['book', 'user'])
            ->where('status_id', $statusEmprestado->id)
            ->where('end_date', '<', Carbon::now())
            ->orderBy('end_date', 'asc')
            ->get();

        return view('loans.overdue', compact('overdueLoans'));
    }
}
