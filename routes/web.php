<?php

use App\Http\Controllers\UsersBookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/loans', [UsersBookController::class, 'store'])->name('loans.store');
Route::post('/loans/{id}/return', [UsersBookController::class, 'devolver'])->name('loans.return');
Route::get('/loans/overdue', [UsersBookController::class, 'atrasados'])->name('loans.overdue');
