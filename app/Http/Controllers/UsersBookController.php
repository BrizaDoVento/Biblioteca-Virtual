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
        $loans = \App\Models\UsersBooks::with(['book', 'user', 'getStatus'])->orderBy('start_date','desc')->get();
        $books = \App\Models\Book::orderBy('title')->get();
        $users = \App\Models\User::orderBy('name')->get();

        return view('loans.index', compact('loans','books','users'));
    }

    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'book_id' => 'required|exists:books,id',
    ]);

    $userId = $request->input('user_id');
    $bookId = $request->input('book_id');

    $book = \App\Models\Book::find($bookId);
    if (!$book || $book->amount < 1) {
        return redirect()->back()->with('error','Livro sem estoque disponível.');
    }

    // se usa tabela users_books_status: checar "Emprestado"
    $status = \App\Models\UsersBookStatus::where('description','Emprestado')->first();
    if (!$status) {
        return redirect()->back()->with('error','Status "Emprestado" não encontrado. Rode a seeder.');
    }

    // verifica limite de 2 livros ativos para o usuário
    $activeLoans = \App\Models\UsersBooks::where('user_id', $userId)
        ->where('status_id', $status->id)
        ->count();

    if ($activeLoans >= 2) {
        return redirect()->back()->with('error','Usuário já tem 2 livros emprestados.');
    }

    // cria empréstimo
    \App\Models\UsersBooks::create([
        'user_id' => $userId,
        'book_id' => $book->id,
        'status_id' => $status->id,
        'start_date' => now(),
        'end_date' => now()->addDays(7),
    ]);

    // decrementa estoque
    $book->decrement('amount');

    return redirect()->route('loans.index')->with('success','Livro emprestado com sucesso!');
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
