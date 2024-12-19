<?php

namespace App\Http\Controllers;

use App\Models\Journal;  // Pastikan untuk mengimpor model Journal

use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index()
    {
        // Ambil semua data jurnal dari database
        $journals = Journal::all();
        return view('journals.index', compact('journals'));
    }

    // Tampilkan form untuk menambah jurnal baru
    public function create()
    {
        return view('journals.create');
    }

    // Simpan jurnal baru ke database
    public function store(Request $request)
    {
        // Validasi inputan dari form
        $request->validate([
            'judul' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'isbn' => 'required|string|max:255|unique:journals,isbn', // Validasi ISBN unik
        ]);

        // Simpan data jurnal baru
        Journal::create($request->all());

        return redirect()->route('journals.index')->with('success', 'Jurnal berhasil ditambahkan.');
    }

    // Tampilkan detail dari jurnal berdasarkan id
    public function show($id)
    {
        $journal = Journal::findOrFail($id); // Cari jurnal berdasarkan id
        return view('journals.show', compact('journal'));
    }

    // Tampilkan form untuk mengedit data jurnal
    public function edit($id)
    {
        $journal = Journal::findOrFail($id); // Cari jurnal berdasarkan id
        return view('journals.edit', compact('journal'));
    }

    // Update data jurnal di database
    public function update(Request $request, $id)
    {
        // Validasi inputan dari form
        $request->validate([
            'judul' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'isbn' => 'required|string|max:255|unique:journals,isbn,' . $id, // Validasi ISBN unik kecuali untuk jurnal yang sedang diedit
        ]);

        // Cari jurnal berdasarkan id
        $journal = Journal::findOrFail($id);
        $journal->update($request->all()); // Update data jurnal

        return redirect()->route('journals.index')->with('success', 'Jurnal berhasil diperbarui.');
    }

    // Hapus jurnal dari database
    public function destroy($id)
    {
        // Cari jurnal berdasarkan id
        $journal = Journal::findOrFail($id);
        $journal->delete(); // Hapus data jurnal

    }
}
