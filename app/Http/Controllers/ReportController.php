<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'petugas') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        $status = $request->input('status', 'all');

        $query = Borrowing::with(['user', 'book'])
            ->whereDate('tanggal_pinjam', '>=', $startDate)
            ->whereDate('tanggal_pinjam', '<=', $endDate);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $transactions = $query->orderBy('tanggal_pinjam', 'desc')->get();

        $summary = [
            'total_transaksi' => $transactions->count(),
            'total_denda' => $transactions->sum('denda'),
            'buku_kembali' => $transactions->where('status', 'DIKEMBALIKAN')->count(),
            'buku_dipinjam' => $transactions->where('status', 'DIPINJAM')->count(),
        ];

        return view('reports.index', compact('transactions', 'startDate', 'endDate', 'status', 'summary'));
    }
}
