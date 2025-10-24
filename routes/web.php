<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UsersBookController;

Route::get('/', function () {
    return redirect()->route('book-management.index');
});

Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('book-management.index');
    Route::get('/create', [BookController::class, 'create'])->name('book-management.create');
    Route::post('/create', [BookController::class, 'store'])->name('books.store');
    Route::get('/edit', [BookController::class, 'edit'])->name('book-management.edit');
    Route::put('/edit', [BookController::class, 'update'])->name('book-management.update');
    Route::put('/destroy', [BookController::class, 'destroy'])->name('book-management.destroy');
});

Route::prefix('loans')->group(function () {
    Route::get('/', [UsersBookController::class, 'index'])->name('loans.index');
    Route::get('/create', [UsersBookController::class, 'create'])->name('loans.create');
    Route::post('/', [UsersBookController::class, 'store'])->name('loans.store');
    Route::post('/{id}/return', [UsersBookController::class, 'devolver'])->name('loans.return');
    Route::get('/overdue', [UsersBookController::class, 'atrasados'])->name('loans.overdue');
});
