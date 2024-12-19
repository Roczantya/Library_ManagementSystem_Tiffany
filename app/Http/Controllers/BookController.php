<?php

namespace App\Http\Controllers;
use App\Models\Book; 
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        // Logic untuk menampilkan semua produk
        $books = Book::all(); // Perbaiki variabel menjadi $books
        return view('books.index', compact('book'));
    }

    public function create(){
        return view('books.create');

    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'ISBN' => 'required|string|max:255',
            'isEbook' => 'required|boolean',
            'ebookLink' => 'required|string|max:255',
            'isBorrowed' => 'required|boolean',

        ]);

        Book::create($request->all());

        return redirect()->route('book.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show($id)
    {
        $book = book::findOrFail($id);
        return view('book.show', compact('book'));
    }

    // Tampilkan form untuk mengedit buku
    public function edit($id)
    {
        $Book = Book::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    // Update buku di database
    public function update(Request $request, $id)
    {
        $request->validate([
           'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'ISBN' => 'required|string|max:255',
            'isEbook' => 'required|boolean',
            'ebookLink' => 'required|string|max:255',
            'isBorrowed' => 'required|boolean',
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->all());

        return redirect()->route('book.index')->with('success', 'Buku berhasil diperbarui.');
    }

    // Hapus buku dari database
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('book.index')->with('success', 'Buku berhasil dihapus.');
    }
}
