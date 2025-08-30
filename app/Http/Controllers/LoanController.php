<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index() {
        return Loan::with(['user','book'])->get();
    }

    public function show($id) {
        return Loan::with(['user','book'])->findOrFail($id);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'status' => 'required|in:dipinjam,dikembalikan'
        ]);

        return Loan::create($validated);
    }

    public function update(Request $request, $id) {
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

    public function destroy($id) {
        $loan = Loan::findOrFail($id);
        $loan->delete();
        return response()->json(['message' => 'Loan deleted']);
    }
}
