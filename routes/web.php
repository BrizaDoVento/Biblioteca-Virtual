<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UsersBookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui ficam todas as rotas da Biblioteca Virtual.
| A rota principal redireciona para /books.
|
*/

// Página inicial → redireciona para lista de livros
Route::get('/', function () {
    return redirect()->route('books.index');
});

// Listagem de livros
Route::get('/books', [BookController::class, 'index'])->name('books.index');

Route::prefix('loans')->group(function () {
    // Página principal - lista de empréstimos
    Route::get('/', [UsersBookController::class, 'index'])->name('loans.index');

    // Registrar novo empréstimo
    Route::post('/', [UsersBookController::class, 'store'])->name('loans.store');

    // Devolver um livro emprestado
    Route::post('/{id}/return', [UsersBookController::class, 'devolver'])->name('loans.return');

    // Listar livros atrasados
    Route::get('/overdue', [UsersBookController::class, 'atrasados'])->name('loans.overdue');
});
