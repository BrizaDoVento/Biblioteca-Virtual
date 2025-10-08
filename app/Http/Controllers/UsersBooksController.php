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
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $bookId = $request->book_id;

        // Conta empréstimos ativos
        $ativos = UsersBook::where('user_id', $user->id)
            ->where('status_id', UsersBookStatus::EMPRESTADO)
            ->count();

        if ($ativos >= 2) {
            return back()->withErrors('Usuário já possui 2 livros emprestados.');
        }

        try {
            DB::transaction(function() use ($user, $bookId) {
                // trava linha do livro para evitar race condition
                $book = Book::where('id', $bookId)->lockForUpdate()->firstOrFail();

                if ($book->amount < 1) {
                    throw new \Exception('Livro sem estoque disponível.');
                }

                $loan = UsersBook::create([
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

    public function devolver($id)
    {
        $loan = UsersBook::findOrFail($id);

        if ($loan->status_id != UsersBookStatus::EMPRESTADO) {
            return back()->withErrors('Empréstimo inválido para devolução.');
        }

        DB::transaction(function() use ($loan) {
            $loan->update(['status_id' => UsersBookStatus::DEVOLVIDO]);
            // trava o livro antes de incrementar
            $book = Book::where('id', $loan->book_id)->lockForUpdate()->first();
            $book->increment('amount');
        });

        return back()->with('success','Livro devolvido com sucesso.');
    }

    public function atrasados()
    {
        $hoje = now()->toDateString();
        $atrasados = UsersBook::where('end_date', '<', $hoje)
            ->where('status_id', UsersBookStatus::EMPRESTADO)
            ->with(['user','book'])
            ->get();

        return view('loans.atrasados', compact('atrasados'));
    }
}
