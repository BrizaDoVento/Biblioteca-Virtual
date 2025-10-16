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

Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/', [BookController::class, 'store'])->name('books.store');
});

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

Route::prefix('book-management')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('book-management.index');
    Route::get('/create', [BookController::class, 'create'])->name('book-management.create');
    Route::post('/', [BookController::class, 'store'])->name('book-management.store');
    Route::get('/{book}/edit', [BookController::class, 'edit'])->name('book-management.edit');
    Route::put('/{book}', [BookController::class, 'update'])->name('book-management.update');
    Route::delete('/{book}', [BookController::class, 'destroy'])->name('book-management.destroy');
});
