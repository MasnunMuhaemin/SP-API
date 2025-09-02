<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('/books', [BookController::class, 'index']); // daftar buku
    Route::get('/loans', [UserController::class, 'myLoans']); // pinjaman user sendiri
    Route::post('/loans', [UserController::class, 'borrow']); // pinjam buku
});

// --------------------- PETUGAS ---------------------
// Role petugas: bisa mengelola pinjaman dan buku
Route::middleware('auth:sanctum')->prefix('petugas')->group(function () {
    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books', [BookController::class, 'store']);
    Route::get('/books/{id}', [BookController::class, 'show']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    Route::get('/loans', [LoanController::class, 'index']); // semua pinjaman
    Route::patch('/loans/{id}/return', [LoanController::class, 'returnLoan']);
    Route::post('/loans', [LoanController::class, 'borrow']); // pinjam buku
});

Route::middleware('auth:sanctum')->prefix('admin')->group(function() {
Route::get('/users', [AdminController::class, 'index']);
Route::post('/users', [AdminController::class, 'store']);
Route::put('/users/{id}', [AdminController::class, 'update']);
Route::delete('/users/{id}', [AdminController::class, 'destroy']);
Route::get('/books', [BookController::class, 'index']);
Route::post('/books', [BookController::class, 'store']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::put('/books/{id}', [BookController::class, 'update']);
Route::delete('/books/{id}', [BookController::class, 'destroy']);
Route::get('/loans', [LoanController::class, 'index']); // semua pinjaman
// Route::put('/loans/{id}/return', [LoanController::class, 'returnLoan']);
// Route::post('/loans', [LoanController::class, 'borrow']); // tambah pinjaman baru
});
