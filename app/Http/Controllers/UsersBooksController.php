<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminte\Support\Facades\DB;
use App\Models\User;
use App\Models\Book;
use App\Models\UsersBooks;

class UsersBookController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exissts:books,id',
        ]);

        $user =
        User::findOrFail($request->user_id);
        $bookid = $request->book_id;

        // Conta empréstimos atvios
        $ativos = UsersBooks::where('user_id', )
    }
}
