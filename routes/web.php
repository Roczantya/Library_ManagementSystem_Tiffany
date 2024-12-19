<?php

use Illuminate\Foundation\Auth\RegisteredUserControllerController;
use Illuminate\Foundation\Auth\AuthenticatedSessionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CDController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\LibrarianController;
use App\Http\Controllers\NewsspaperController;
use App\Http\Controllers\SkripsiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:librarian'])->group(function () {
    Route::get('/librarian/dashboard', [LibrarianController::class, 'index'])->name('librarian.dashboard');
});

Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'index'])->name('mahasiswa.dashboard');
});

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');
    
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard'); // Ganti dengan rute tujuan setelah verifikasi
    })->middleware(['auth', 'signed'])->name('verification.verify');
    
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
    
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    Route::get('/dashboard', function () {
        return view('mahasiswa.dashboard');
    })->middleware(['auth', 'verified']);
    
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminController::class, 'login']);
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('add-librarian', [AdminController::class, 'addLibrarian']);
        Route::delete('delete-librarian/{id}', [AdminController::class, 'deleteLibrarian']);
        Route::get('manage-requests', [AdminController::class, 'manageRequests']);
        Route::post('approve-request/{id}', [AdminController::class, 'approveRequest']);
        Route::post('deny-request/{id}', [AdminController::class, 'denyRequest']);
    });
});


Route::prefix('librarian')->group(function () {
    Route::get('login', [LibrarianController::class, 'showLoginForm'])->name('librarian.login');
    Route::post('login', [LibrarianController::class, 'login']);
    Route::middleware('auth:librarian')->group(function () {
        Route::get('dashboard', [LibrarianController::class, 'dashboard'])->name('librarian.dashboard');
        Route::post('add-book', [LibrarianController::class, 'addBook']);
        Route::post('edit-book/{id}', [LibrarianController::class, 'editBook']);
        Route::delete('delete-book/{id}', [LibrarianController::class, 'deleteBook']);
        Route::get('manage-requests', [LibrarianController::class, 'manageRequests']);
        Route::post('approve-request/{id}', [LibrarianController::class, 'approveRequest']);
        Route::post('deny-request/{id}', [LibrarianController::class, 'denyRequest']);
        Route::post('request-item-to-admin', [LibrarianController::class, 'requestItemToAdmin']);
    });
});

Route::middleware('auth', 'role:librarian')->group(function () {
    Route::resource('books', BookController::class);
    Route::resource('journals', JournalController::class);
    Route::resource('skripsis', ThesisController::class);
    Route::resource('newsspapers', NewsspaperController::class);
    Route::resource('cds', CDController::class);
});

Route::resource('books', BookController::class);
 Route::get('books', [BookController::class, 'index'])->name('books.index');
 Route::get('books/create', [BookController::class, 'create'])->name('books.create');
 Route::post('books', [BookController::class, 'store'])->name('books.store');
 Route::get('books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
 Route::put('books/{id}', [BookController::class, 'update'])->name('books.update');
 Route::delete('books/{id}', [BookController::class, 'destroy'])->name('books.destroy');

 Route::resource('journals', JournalController::class);
  Route::get('journals', [JournalController::class, 'index'])->name('journals.index');
  Route::get('journals/create', [JournalController::class, 'create'])->name('journals.create');
  Route::post('journals', [JournalController::class, 'store'])->name('journals.store');
  Route::get('journals/{id}/edit', [JournalController::class, 'edit'])->name('journals.edit');
  Route::put('journals/{id}', [JournalController::class, 'update'])->name('journals.update');
  Route::delete('journals/{id}', [JournalController::class, 'destroy'])->name('journals.destroy');

Route::resource('cds', CDController::class);
  Route::get('cds', [CDController::class, 'index'])->name('cds.index');
  Route::get('cds/create', [CDController::class, 'create'])->name('cds.create');
  Route::post('cds', [CDController::class, 'store'])->name('cds.store');
  Route::get('cds/{id}/edit', [CDController::class, 'edit'])->name('cds.edit');
  Route::put('cds/{id}', [CDController::class, 'update'])->name('cds.update');
  Route::delete('cds/{id}', [CDController::class, 'destroy'])->name('cds.destroy');

Route::resource('newsspapers', NewsspaperController::class);
  Route::get('newsspapers', [NewsspaperController::class, 'index'])->name('newsspapers.index');
  Route::get('newsspapers/create', [NewsspaperController::class, 'create'])->name('newsspapers.create');
  Route::post('newsspapers', [NewsspaperController::class, 'store'])->name('newsspapers.store');
  Route::get('newsspapers/{id}/edit', [NewsspaperController::class, 'edit'])->name('newsspapers.edit');
  Route::put('newsspapers/{id}', [NewsspaperController::class, 'update'])->name('newsspapers.update');
  Route::delete('newsspapers/{id}', [NewsspaperController::class, 'destroy'])->name('newsspapers.destroy');

  
Route::resource('skripsis', SkripsiController::class);
Route::get('skripsis', [SkripsiController::class, 'index'])->name('skripsis.index');
Route::get('skripsis/create', [SkripsiController::class, 'create'])->name('skripsis.create');
Route::post('skripsis', [SkripsiController::class, 'store'])->name('skripsis.store');
Route::get('skripsis/{id}/edit', [SkripsiController::class, 'edit'])->name('skripsis.edit');
Route::put('skripsis/{id}', [SkripsiController::class, 'update'])->name('skripsis.update');
Route::delete('skripsis/{id}', [SkripsiController::class, 'destroy'])->name('skripsis.destroy');

  require __DIR__.'/auth.php';
