<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function myLoans()
    {
        $userId = Auth::id(); // ambil ID user yang login
        $loans = Loan::with('book') // ambil data buku terkait
            ->where('user_id', $userId)
            ->get();

        return response()->json($loans);
    }

    public function index()
    {
        return Loan::with(['user', 'book'])->get();
    }

    public function show($id)
    {
        return Loan::with(['user', 'book'])->findOrFail($id);
    }

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
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'dipinjam',
        ]);

        return response()->json($loan, 201);
    }


    public function update(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'book_id' => 'sometimes|exists:books,id',
            'tanggal_pinjam' => 'sometimes|date',
            'tanggal_kembali' => 'nullable|date',
            'status' => 'sometimes|in:dipinjam,dikembalikan'
        ]);

        $loan->update($validated);
        return $loan;
    }

    public function destroy($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->delete();
        return response()->json(['message' => 'Loan deleted']);
    }

    public function returnLoan($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->status = 'dikembalikan';
        $loan->tanggal_kembali = now();
        $loan->save();

        return response()->json($loan);
    }
}
