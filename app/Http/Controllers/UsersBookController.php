<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersBooks;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;

class UsersBookController extends Controller
{
    // Exibe lista de empréstimos
    public function index()
    {
        $loans = UsersBooks::with('book', 'user')->orderBy('start_date', 'desc')->get();
        $books = Book::where('amount', '>', 0)->orderBy('title')->get(); // livros disponíveis

        return view('loans.index', compact('loans', 'books'));
    }

    // Formulário de novo empréstimo (opcional se usar index com select)
    public function create()
    {
        $books = Book::where('amount', '>', 0)->orderBy('title')->get();
        $users = User::orderBy('name')->get();
        return view('loans.create', compact('books', 'users'));
    }

    // Registrar novo empréstimo
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $book = Book::find($request->book_id);
        $userId = $request->user_id;

        // Verifica estoque
        if ($book->amount < 1) {
            return redirect()->back()->with('error', 'Livro sem estoque disponível.');
        }

        // Verifica se usuário já tem 2 empréstimos ativos
        $activeLoans = UsersBooks::where('user_id', $userId)
            ->where('status', 'Emprestado')
            ->count();

        if ($activeLoans >= 2) {
            return redirect()->back()->with('error', 'Usuário já possui 2 livros emprestados.');
        }

        // Cria empréstimo
        $loan = UsersBooks::create([
            'user_id' => $userId,
            'book_id' => $book->id,
            'status' => 'Emprestado',
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(7),
        ]);

        // Atualiza estoque
        $book->decrement('amount');

        return redirect()->route('loans.index')->with('success', 'Empréstimo registrado com sucesso!');
    }

    // Devolver livro
    public function devolver($id)
    {
        $loan = UsersBooks::findOrFail($id);

        if ($loan->status === 'Devolvido') {
            return redirect()->back()->with('error', 'Este livro já foi devolvido.');
        }

        $loan->status = 'Devolvido';
        $loan->save();

        // Atualiza estoque
        $loan->book->increment('amount');

        return redirect()->route('loans.index')->with('success', 'Livro devolvido com sucesso!');
    }

    // Listar empréstimos atrasados
    public function atrasados()
    {
        $overdueLoans = UsersBooks::with('book', 'user')
            ->where('status', 'Emprestado')
            ->where('end_date', '<', Carbon::now())
            ->orderBy('end_date')
            ->get();

        return view('loans.overdue', compact('overdueLoans'));
    }
}
