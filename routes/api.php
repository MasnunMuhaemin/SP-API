<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::get('/books', [BookController::class, 'index']); // daftar buku
    Route::get('/loans', [LoanController::class, 'myLoans']); // pinjaman user sendiri
    Route::post('/loans', [LoanController::class, 'borrow']); // pinjam buku
});

// --------------------- PETUGAS ---------------------
// Role petugas: bisa mengelola pinjaman dan buku
Route::middleware(['auth:sanctum', 'role:petugas'])->group(function () {
    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books', [BookController::class, 'store']);
    Route::get('/books/{id}', [BookController::class, 'show']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    Route::get('/loans', [LoanController::class, 'index']); // semua pinjaman
    Route::put('/loans/{id}/return', [LoanController::class, 'returnBook']); // kembalikan buku
});

// Route::middleware(['auth:sanctum', 'admin'])->group(function() {
Route::get('/admin/users', [AdminController::class, 'index']);
Route::post('/admin/users', [AdminController::class, 'store']);
Route::put('/admin/users/{user}', [AdminController::class, 'update']);
Route::delete('/admin/users/{user}', [AdminController::class, 'destroy']);
Route::get('/admin/books', [BookController::class, 'index']);
Route::post('/admin/books', [BookController::class, 'store']);
Route::get('/admin/books/{id}', [BookController::class, 'show']);
Route::put('/admin/books/{id}', [BookController::class, 'update']);
Route::delete('/admin/books/{id}', [BookController::class, 'destroy']);
Route::get('/admin/loans', [LoanController::class, 'index']); // semua pinjaman
Route::put('/admin/loans/{id}/return', [LoanController::class, 'returnBook']);
// });
