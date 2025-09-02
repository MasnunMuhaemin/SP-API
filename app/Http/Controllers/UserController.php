<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function borrow(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stok <= 0) {
            return response()->json([
                'message' => 'Stok buku habis, tidak bisa dipinjam'
            ], 400);
        }

        // kurangi stok
        $book->stok -= 1;
        $book->save();

        $loan = Loan::create([
            'user_id' => Auth::id(), // otomatis ambil user login
            'book_id' => $request->book_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'dipinjam',
        ]);

        return response()->json($loan, 201);
    }

    public function myLoans()
    {
        $loans = Loan::with('book')->where('user_id', Auth::id())->get();
        return response()->json($loans);
    }
}
