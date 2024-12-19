<?php

namespace App\Http\Controllers;
use App\Models\Loan;
use Illuminate\Http\Request;

class LibrarianController extends Controller
{
    // Halaman Login Librarian
    public function showLoginForm()
    {
        return view('librarian.login');
    }

    // Proses Login Librarian
    public function login(HttpRequest $request)
    {
        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->route('librarian.dashboard');
        }

        return redirect()->back()->withErrors(['Invalid credentials']);
    }

    // Dashboard Librarian
    public function dashboard()
    {
        $books = Book::all();
        $requests = Request::where('status', 'pending')->get();
        return view('librarian.dashboard', compact('books', 'requests'));
    }

    // Menambah Buku, Jurnal, CD, dan Skripsi
    public function addBook(HttpRequest $request)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required', // buku, jurnal, CD, skripsi
            'author' => 'required',
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->type = $request->type;
        $book->author = $request->author;
        $book->save();

        return redirect()->route('librarian.dashboard')->with('success', 'Book added successfully');
    }

    // Mengedit Buku, Jurnal, CD, dan Skripsi
    public function editBook(HttpRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->title = $request->title;
        $book->author = $request->author;
        $book->type = $request->type;
        $book->save();

        return redirect()->route('librarian.dashboard')->with('success', 'Book updated successfully');
    }

    // Menghapus Buku, Jurnal, CD, dan Skripsi
    public function deleteBook($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('librarian.dashboard')->with('success', 'Book deleted successfully');
    }

    // Mengelola Permintaan Peminjaman dari Mahasiswa
    public function manageRequests()
    {
        $requests = Request::where('status', 'pending')->get();
        return view('librarian.manageRequests', compact('requests'));
    }

    // Mengacc Permintaan Peminjaman Buku
    public function approveRequest($id)
    {
        $request = Request::findOrFail($id);
        $request->status = 'approved';
        $request->save();

        return redirect()->route('librarian.manageRequests')->with('success', 'Request approved');
    }

    // Menolak Permintaan Peminjaman Buku
    public function denyRequest($id)
    {
        $request = Request::findOrFail($id);
        $request->status = 'denied';
        $request->save();

        return redirect()->route('librarian.manageRequests')->with('success', 'Request denied');
    }

    // Mengajukan Permintaan Buku, Jurnal, CD, dan Skripsi kepada Admin
    public function requestItemToAdmin(HttpRequest $request)
    {
        $request->validate([
            'item_id' => 'required',
            'type' => 'required',
        ]);

        $adminRequest = new Request();
        $adminRequest->item_id = $request->item_id;
        $adminRequest->type = $request->type;
        $adminRequest->status = 'pending';  // Menunggu approval admin
        $adminRequest->save();

        return redirect()->route('librarian.dashboard')->with('success', 'Request sent to admin');
    }

    public function processLoan($id)
    {
        $loanRequest = LoanRequest::findOrFail($id);

        if ($loanRequest->status === 'approved') {
            // Librarian memproses peminjaman, menandai status item sebagai dipinjam
            $item = $loanRequest->item;
            $item->is_borrowed = true;
            $item->save();

            return response()->json(['message' => 'Item berhasil dipinjam.']);
        }

        return response()->json(['message' => 'Permintaan belum disetujui oleh admin.'], 400);
    }

    public function returnLoan($id)
    {
        $loanRequest = LoanRequest::findOrFail($id);

        // Mengembalikan buku dan menandai item sebagai tersedia
        $item = $loanRequest->item;
        $item->is_borrowed = false;
        $item->save();

        // Mengupdate status permintaan menjadi 'returned' atau lainnya
        $loanRequest->status = 'returned';
        $loanRequest->save();

        return response()->json(['message' => 'Item telah dikembalikan dan status diperbarui.']);
    }
}
