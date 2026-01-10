<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            body { background: white; }
            .shadow-sm { box-shadow: none !important; }
            .border { border: 1px solid #ddd !important; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        <div class="bg-slate-800 text-white p-2 rounded-lg font-bold">SIP</div>
                        <span class="font-semibold text-lg text-slate-700">Kembali ke Dashboard</span>
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-sm text-right hidden sm:block">
                        <p class="font-medium text-slate-900">{{ Auth::user()->nama }}</p>
                        <p class="text-xs text-slate-500 uppercase tracking-wider">Laporan & Statistik</p>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 no-print">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Laporan Transaksi</h1>
                <p class="text-slate-500 text-sm">Rekapitulasi peminjaman dan pengembalian buku.</p>
            </div>
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Laporan (PDF)
            </button>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 mb-8 no-print">
            <form action="{{ route('reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="w-full rounded-lg border-slate-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="w-full rounded-lg border-slate-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Status</label>
                    <select name="status" class="w-full rounded-lg border-slate-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="DIPINJAM" {{ $status == 'DIPINJAM' ? 'selected' : '' }}>Sedang Dipinjam</option>
                        <option value="DIKEMBALIKAN" {{ $status == 'DIKEMBALIKAN' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </div>
                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition">Filter Data</button>
            </form>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden print:border-0">
            <div class="px-6 py-6 border-b border-slate-200 bg-slate-50 print:bg-white print:px-0">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Laporan Periode {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</h2>
                        <p class="text-sm text-slate-500 mt-1">Dicetak oleh: {{ Auth::user()->nama }} pada {{ now()->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-4 mt-6 pt-6 border-t border-slate-200">
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Total Transaksi</p>
                        <p class="text-xl font-bold text-slate-800">{{ $summary['total_transaksi'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Dipinjam</p>
                        <p class="text-xl font-bold text-slate-800">{{ $summary['buku_dipinjam'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Dikembalikan</p>
                        <p class="text-xl font-bold text-slate-800">{{ $summary['buku_kembali'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Total Pendapatan Denda</p>
                        <p class="text-xl font-bold text-slate-800">Rp {{ number_format($summary['total_denda'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs print:bg-slate-100">
                    <tr>
                        <th class="px-6 py-3 border-b print:px-2">Tanggal</th>
                        <th class="px-6 py-3 border-b print:px-2">Peminjam</th>
                        <th class="px-6 py-3 border-b print:px-2">Buku</th>
                        <th class="px-6 py-3 border-b print:px-2">Status</th>
                        <th class="px-6 py-3 border-b print:px-2 text-right">Denda</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transactions as $t)
                    <tr>
                        <td class="px-6 py-3 print:px-2">{{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d/m/Y') }}</td>
                        <td class="px-6 py-3 print:px-2">
                            <div class="font-medium">{{ $t->user->nama }}</div>
                            <div class="text-xs text-slate-500">{{ $t->user->role }}</div>
                        </td>
                        <td class="px-6 py-3 print:px-2">{{ $t->book->judul }}</td>
                        <td class="px-6 py-3 print:px-2">
                            <span class="px-2 py-1 rounded text-[10px] font-bold uppercase border {{ $t->status === 'DIPINJAM' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-slate-50 text-slate-600 border-slate-200' }}">
                                {{ $t->status }}
                            </span>
                        </td>
                        <td class="px-6 py-3 print:px-2 text-right font-medium text-slate-700">
                            {{ $t->denda > 0 ? 'Rp '.number_format($t->denda, 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">Tidak ada data transaksi pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
