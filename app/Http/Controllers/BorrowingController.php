<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function store(Request $request)
    {
        $book = Book::findOrFail($request->book_id);

        if ($book->stok < 1) {
            return back()->with('error', 'Stok buku tidak tersedia.');
        }

        $existingBorrow = Borrowing::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->where('status', 'DIPINJAM')
            ->exists();

        if ($existingBorrow) {
            return back()->with('error', 'Anda sedang meminjam buku ini.');
        }

        Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'tanggal_pinjam' => now(),
            'status' => 'DIPINJAM',
            'denda' => 0
        ]);

        $book->updateStok(-1);

        return back()->with('success', 'Peminjaman berhasil diproses.');
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'DIPINJAM') {
            return back()->with('error', 'Buku sudah dikembalikan sebelumnya.');
        }

        $tanggalPinjam = Carbon::parse($borrowing->tanggal_pinjam);
        $tanggalKembali = now();
        $durasiPinjam = $tanggalPinjam->diffInDays($tanggalKembali);

        $denda = 0;
        $batasWaktu = 7;
        $biayaDendaPerHari = 1000;

        if ($durasiPinjam > $batasWaktu) {
            $hariTerlambat = $durasiPinjam - $batasWaktu;
            $denda = $hariTerlambat * $biayaDendaPerHari;
        }

        $borrowing->update([
            'status' => 'DIKEMBALIKAN',
            'tanggal_kembali' => $tanggalKembali,
            'denda' => $denda
        ]);

        $borrowing->book->updateStok(1);

        $pesan = 'Buku berhasil dikembalikan.';
        if ($denda > 0) {
            $pesan .= ' Terdapat denda keterlambatan sebesar Rp ' . number_format($denda, 0, ',', '.');
        }

        return back()->with('success', $pesan);
    }
}
