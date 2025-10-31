<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UsersBookController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Todas as rotas da Biblioteca Virtual estão definidas aqui.
| A rota principal redireciona para /books.
|
*/

// Página inicial → redireciona para lista de livros
Route::get('/', function () {
    return redirect()->route('books.index');
});

// ------------------------
// ROTAS DE LIVROS
// ------------------------
Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/', [BookController::class, 'store'])->name('books.store');
    Route::get('/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/{book}', [BookController::class, 'destroy'])->name('books.destroy');
});

// ------------------------
// ROTAS DE EMPRÉSTIMOS (UsersBooks)
// ------------------------
Route::prefix('loans')->group(function () {
    Route::get('/', [UsersBookController::class, 'index'])->name('loans.index');       // Lista de empréstimos
    Route::get('/create', [UsersBookController::class, 'create'])->name('loans.create'); // Formulário novo empréstimo
    Route::post('/', [UsersBookController::class, 'store'])->name('loans.store');       // Registrar empréstimo
    Route::post('/{id}/return', [UsersBookController::class, 'devolver'])->name('loans.return'); // Devolver livro
    Route::get('/overdue', [UsersBookController::class, 'atrasados'])->name('loans.overdue');    // Livros atrasados
});

// ------------------------
// ROTAS DE GERENCIAMENTO DE LIVROS (opcional)
// ------------------------
Route::prefix('book-management')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('book-management.index');
    Route::get('/create', [BookController::class, 'create'])->name('book-management.create');
    Route::post('/', [BookController::class, 'store'])->name('book-management.store');
    Route::get('/{book}/edit', [BookController::class, 'edit'])->name('book-management.edit');
    Route::put('/{book}', [BookController::class, 'update'])->name('book-management.update');
    Route::delete('/{book}', [BookController::class, 'destroy'])->name('book-management.destroy');
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
