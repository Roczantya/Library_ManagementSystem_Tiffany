<?php

namespace App\Http\Controllers;
use App\Models\CD; 
use Illuminate\Http\Request;

class CDController extends Controller
{
    public function index()
    {
        // Ambil semua data album dari database
        $c_d_s = CD::all();
        return view('cds.index', compact('cds'));
    }

    // Tampilkan form untuk menambah cd baru
    public function create()
    {
        return view('cds.create');
    }

    // Simpan cd baru ke database
    public function store(Request $request)
    {
        // Validasi inputan dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'release_year' => 'required|integer',
            'genre' => 'required|string|max:255',
        ]);

        // Simpan data cd baru
        CD::create($request->all());

        return redirect()->route('cds.index')->with('success', 'cd berhasil ditambahkan.');
    }

    // Tampilkan detail dari cd berdasarkan id
    public function show($id)
    {
        $cd = CD::findOrFail($id); // Cari cd berdasarkan id
        return view('cds.show', compact('cd'));
    }

    // Tampilkan form untuk mengedit data cd
    public function edit($id)
    {
        $cd = CD::findOrFail($id); // Cari cd berdasarkan id
        return view('cds.edit', compact('cd'));
    }

    // Update data cd di database
    public function update(Request $request, $id)
    {
        // Validasi inputan dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'release_year' => 'required|integer',
            'genre' => 'required|string|max:255',
        ]);

        // Cari cd berdasarkan id
        $cd = CD::findOrFail($id);
        $cd->update($request->all()); // Update data cd

        return redirect()->route('cds.index')->with('success', 'cd berhasil diperbarui.');
    }

    // Hapus cd dari database
    public function destroy($id)
    {
        // Cari cd berdasarkan id
        $cd = CD::findOrFail($id);
        $cd->delete(); // Hapus data cd

        return redirect()->route('cds.index')->with('success', 'cd berhasil dihapus.');
    }
}
