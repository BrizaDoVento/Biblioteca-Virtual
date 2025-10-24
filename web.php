<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UsersBookController;

Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/', [BookController::class, 'store'])->name('books.store');
});

Route::prefix('loans')->group(function () {
    Route::get('/', [UsersBookController::class, 'index'])->name('loans.index');
    Route::get('/create', [UsersBookController::class, 'create'])->name('loans.create');
    Route::post('/', [UsersBookController::class, 'store'])->name('loans.store');
    Route::post('/{id}/return', [UsersBookController::class, 'devolver'])->name('loans.return');
    Route::get('/overdue', [UsersBookController::class, 'atrasados'])->name('loans.overdue');
});
