<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UsersBookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rotas principais da Biblioteca Virtual
|
*/

// Página inicial → redireciona para lista de livros
Route::get('/', function () {
    return redirect()->route('books.index');
});

// 📚 CRUD de Livros
Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/', [BookController::class, 'store'])->name('books.store');
    Route::get('/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/{book}', [BookController::class, 'destroy'])->name('books.destroy');
});

// 📖 ROTAS DE EMPRÉSTIMOS
Route::prefix('loans')->group(function () {
    Route::get('/', [UsersBookController::class, 'index'])->name('loans.index');          // listar empréstimos
    Route::get('/create', [UsersBookController::class, 'create'])->name('loans.create');  // criar novo empréstimo
    Route::post('/', [UsersBookController::class, 'store'])->name('loans.store');         // salvar empréstimo
    Route::post('/{id}/return', [UsersBookController::class, 'devolver'])->name('loans.return'); // devolver livro
    Route::get('/overdue', [UsersBookController::class, 'atrasados'])->name('loans.overdue');     // atrasados
});
