<?php

namespace App\Http\Controllers;
use App\Models\Newsspaper;
use Illuminate\Http\Request;

class NewsspaperController extends Controller
{
    public function index()
    {
        // Ambil semua data newspaper dari database
        $newsspapers = Newsspaper::all();
        return view('newsspapers.index', compact('newsspapers'));
    }

    // Tampilkan form untuk menambah koran baru
    public function create()
    {
        return view('newsspapers.create');
    }

    // Simpan koran baru ke database
    public function store(Request $request)
    {
        // Validasi inputan dari form
        $request->validate([
            'judul_surat_kabar' => 'required|string|max:255',
            'publication_date' => 'required|date',
            'publisher' => 'required|string|max:255',
        ]);

        // Simpan data koran baru
        Newsspaper::create($request->all());

        return redirect()->route('newsspapers.index')->with('success', 'Koran berhasil ditambahkan.');
    }

    // Tampilkan detail dari koran berdasarkan id
    public function show($id)
    {
        $newsspaper = Newsspaper::findOrFail($id); // Cari koran berdasarkan id
        return view('newsspapers.show', compact('newsspaper'));
    }

    // Tampilkan form untuk mengedit data koran
    public function edit($id)
    {
        $newsspaper = Newsspaper::findOrFail($id); // Cari koran berdasarkan id
        return view('newsspapers.edit', compact('newspaper'));
    }

    // Update data koran di database
    public function update(Request $request, $id)
    {
        // Validasi inputan dari form
        $request->validate([
            'judul_surat_kabar' => 'required|string|max:255',
            'publication_date' => 'required|date',
            'publisher' => 'required|string|max:255',
        ]);

        // Cari koran berdasarkan id
        $newsspaper = Newsspaper::findOrFail($id);
        $newsspaper->update($request->all()); // Update data koran

        return redirect()->route('newsspapers.index')->with('success', 'Koran berhasil diperbarui.');
    }

    // Hapus koran dari database
    public function destroy($id)
    {
        // Cari koran berdasarkan id
        $newsspaper = Newsspaper::findOrFail($id);
        $newsspaper->delete(); // Hapus data koran

        return redirect()->route('newsspapers.index')->with('success', 'Koran berhasil dihapus.');
    }
}
