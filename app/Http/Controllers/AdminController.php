<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;

class AdminController extends Controller
{
    // Halaman Login Admin
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Proses Login Admin
    public function login(HttpRequest $request)
    {
        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withErrors(['Invalid credentials']);
    }

    // Dashboard Admin
    public function dashboard()
    {
        $librarians = User::where('role', 'librarian')->get();
        $pendingRequests = Request::where('status', 'pending')->get();
        return view('admin.dashboard', compact('librarians', 'pendingRequests'));
    }

    // Menambah Librarian
    public function addLibrarian(HttpRequest $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);

        $librarian = new User();
        $librarian->username = $request->username;
        $librarian->password = bcrypt($request->password);
        $librarian->role = 'librarian';
        $librarian->save();

        return redirect()->route('admin.dashboard')->with('success', 'Librarian added successfully');
    }

    // Menghapus Librarian
    public function deleteLibrarian($id)
    {
        $librarian = User::findOrFail($id);
        $librarian->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Librarian deleted successfully');
    }

    // Mengelola Permintaan Peminjaman
    public function manageRequests()
    {
        $requests = Request::all();
        return view('admin.manageRequests', compact('requests'));
    }

    // Mengacc Permintaan Peminjaman
    public function approveLoanRequest($id)
    {
        $loanRequest = LoanRequest::findOrFail($id);

        // Menandai permintaan disetujui oleh admin
        $loanRequest->status = 'approved';
        $loanRequest->borrowed_at = Carbon::now(); // Tanggal peminjaman saat ini
        $loanRequest->due_date = Carbon::now()->addWeek(); // Menambahkan 7 hari sebagai due date
        $loanRequest->save();

        // Menandai item sebagai dipinjam
        $item = $loanRequest->item;
        $item->is_borrowed = true;
        $item->save();

        return response()->json(['message' => 'Permintaan disetujui, item telah dipinjam.']);
    }

    // Menolak Permintaan Peminjaman
    public function denyRequest($id)
    {
        $request = Request::findOrFail($id);
        $request->status = 'denied';
        $request->save();

        return redirect()->route('admin.manageRequests')->with('success', 'Request denied');
    }
}
