<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UsersBookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui registramos as rotas do sistema de biblioteca.
| A rota inicial redireciona para a lista de livros.
|
*/

// Rota inicial → redireciona para a listagem de livros
Route::get('/', function () {
    return redirect()->route('books.index');
});

// Listagem de livros
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// Empréstimos
Route::post('/loans', [UsersBookController::class, 'store'])->name('loans.store');
Route::post('/loans/{id}/return', [UsersBookController::class, 'devolver'])->name('loans.return');
Route::get('/loans/overdue', [UsersBookController::class, 'atrasados'])->name('loans.overdue');
