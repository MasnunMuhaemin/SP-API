<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        // tampilkan semua buku + URL gambar
        $books = Book::all()->map(function ($book) {
            if ($book->image) {
                $book->image_url = asset('storage/' . $book->image);
            } else {
                $book->image_url = null;
            }
            return $book;
        });

        return response()->json($books);
    }

     public function store(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'judul'        => 'required|string',
            'penulis'      => 'required|string',
            'penerbit'     => 'nullable|string',
            'tahun_terbit' => 'nullable|integer',
            'stok'         => 'required|integer|min:0',
            'kategori'     => 'nullable|string',
            'image'        => 'nullable|image' // max 2MB
        ]);

        // Handle upload gambar
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        // Pastikan integer nullable dikonversi null jika kosong
        $data['tahun_terbit'] = $data['tahun_terbit'] ?? null;

        // Simpan ke database
        $book = Book::create($data);

        // Tambahkan URL gambar untuk response
        $book->image_url = $book->image ? asset('storage/' . $book->image) : null;

        return response()->json($book, 201);
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        $book->image_url = $book->image ? asset('storage/' . $book->image) : null;

        return response()->json($book);
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $data = $request->validate([
            'judul'        => 'sometimes|string',
            'penulis'      => 'sometimes|string',
            'penerbit'     => 'nullable|string',
            'tahun_terbit' => 'nullable|integer',
            'stok'         => 'sometimes|integer|min:0',
            'kategori'     => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('image')) {
            // hapus gambar lama
            if ($book->image && Storage::disk('public')->exists($book->image)) {
                Storage::disk('public')->delete($book->image);
            }

            $data['image'] = $request->file('image')->store('books', 'public');
        }

        $book->update($data);

        $book->image_url = $book->image ? asset('storage/' . $book->image) : null;

        return response()->json($book);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // hapus file gambar juga
        if ($book->image && Storage::disk('public')->exists($book->image)) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();
        return response()->json(['message' => 'Book deleted']);
    }
}
