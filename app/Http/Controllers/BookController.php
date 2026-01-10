<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');
        // Logika Pencarian & Filter Kategori
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
            });
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $books = $query->get();
        $categories = Category::all();

        $borrowings = [];
        $members = [];
        $stats = [];

        if (Auth::user()->role === 'petugas') {
            $borrowings = Borrowing::with(['user', 'book'])->orderBy('status', 'desc')->get();
            $members = User::where('role', 'anggota')->get();

            $stats = [
                'total_buku' => Book::sum('stok'),
                'total_judul' => Book::count(),
                'total_kategori' => Category::count(),
                'sedang_dipinjam' => Borrowing::where('status', 'DIPINJAM')->count(),
                'total_denda' => Borrowing::sum('denda')
            ];
        } else {
            $borrowings = Borrowing::with('book')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('dashboard', compact('books', 'borrowings', 'members', 'stats', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_buku' => 'required|unique:books',
            'judul' => 'required',
            'category_id' => 'required|exists:categories,id',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'stok' => 'required|integer|min:0'
        ]);

        Book::create($validated);
        return back()->with('success', 'Data buku berhasil ditambahkan.');
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'category_id' => 'required|exists:categories,id',
            'penulis' => 'required',
            'penerbit' => 'required',
            'stok' => 'required|integer|min:0'
        ]);

        $book->update($validated);
        return back()->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return back()->with('success', 'Buku berhasil dihapus dari sistem.');
    }
}
