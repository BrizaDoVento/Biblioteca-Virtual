<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Book;
use App\Models\UsersBook;
use App\Models\UsersBookStatus;

class UsersBookController extends Controller
{
    // Empréstimo
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $bookId = $request->book_id;

        $ativos = UsersBook::where('user_id', $user->id)
            ->where('status_id', UsersBookStatus::EMPRESTADO)
            ->count();

        if ($ativos >= 2) {
            return back()->withErrors('Você já possui 2 livros emprestados.');
        }

        try {
            DB::transaction(function() use ($user, $bookId) {
                $book = Book::where('id', $bookId)->lockForUpdate()->firstOrFail();

                if ($book->amount < 1) {
                    throw new \Exception('Livro sem estoque disponível.');
                }

                UsersBook::create([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                    'status_id' => UsersBookStatus::EMPRESTADO,
                    'start_date' => now()->toDateString(),
                    'end_date' => now()->addDays(7)->toDateString(),
                ]);

                $book->decrement('amount');
            });
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        return back()->with('success','Livro emprestado com sucesso.');
    }

    // Devolução
    public function devolver($id)
    {
        $loan = UsersBook::findOrFail($id);

        if ($loan->status_id != UsersBookStatus::EMPRESTADO) {
            return back()->withErrors('Empréstimo inválido.');
        }

        DB::transaction(function() use ($loan) {
            $loan->update(['status_id' => UsersBookStatus::DEVOLVIDO]);
            $book = Book::where('id', $loan->book_id)->lockForUpdate()->first();
            $book->increment('amount');
        });

        return back()->with('success','Livro devolvido com sucesso.');
    }

    // Empréstimos atrasados
    public function atrasados()
    {
        $atrasados = UsersBook::where('status_id', UsersBookStatus::EMPRESTADO)
            ->where('end_date', '<', now())
            ->with(['user','book'])
            ->get();

        return view('loans.atrasados', compact('atrasados'));
    }
}
