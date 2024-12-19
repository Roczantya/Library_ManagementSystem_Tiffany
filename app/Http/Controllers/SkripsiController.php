<?php

namespace App\Http\Controllers;
use App\Models\Skripsi; 

use Illuminate\Http\Request;

class SkripsiController extends Controller
{
   
    // Tampilkan semua skripsi
    public function index()
    {
        // Ambil semua data skripsi dari database
        $skripsi = Skripsi::all();
        return view('skripsi.index', compact('skripsi'));
    }

    // Tampilkan form untuk menambah skripsi baru
    public function create()
    {
        return view('skripsi.create');
    }

    // Simpan skripsi baru ke database
    public function store(Request $request)
    {
        // Validasi inputan dari form
        $request->validate([
            'judulskripsi' => 'required|string|max:255',
            'nama_mahasiswa' => 'required|string|max:255',
            'dosenpembimbing' => 'required|string|max:255',
            'tahunterbit' => 'required|integer',
            'abstract' => 'required|string',
        ]);

        // Simpan data skripsi baru
        Skripsi::create($request->all());

        return redirect()->route('skripsi.index')->with('success', 'Skripsi berhasil ditambahkan.');
    }

    // Tampilkan detail dari skripsi berdasarkan id
    public function show($id)
    {
        $skripsi = Skripsi::findOrFail($id); // Cari skripsi berdasarkan id
        return view('skripsi.show', compact('skripsi'));
    }

    // Tampilkan form untuk mengedit data skripsi
    public function edit($id)
    {
        $skripsi = Skripsi::findOrFail($id); // Cari skripsi berdasarkan id
        return view('skripsi.edit', compact('skripsi'));
    }

    // Update data skripsi di database
    public function update(Request $request, $id)
    {
        // Validasi inputan dari form
        $request->validate([
            'judulskripsi' => 'required|string|max:255',
            'nama_mahasiswa' => 'required|string|max:255',
            'dosenpembimbing' => 'required|string|max:255',
            'tahunterbit' => 'required|integer',
            'abstract' => 'required|string',
        ]);

        // Cari skripsi berdasarkan id
        $skripsi = Skripsi::findOrFail($id);
        $skripsi->update($request->all()); // Update data skripsi

        return redirect()->route('skripsi.index')->with('success', 'Skripsi berhasil diperbarui.');
    }

    // Hapus skripsi dari database
    public function destroy($id)
    {
        // Cari skripsi berdasarkan id
        $skripsi = Skripsi::findOrFail($id);
        $skripsi->delete(); // Hapus data skripsi

        return redirect()->route('skripsi.index')->with('success', 'Skripsi berhasil dihapus.');
    }
}


