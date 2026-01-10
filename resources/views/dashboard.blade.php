<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-2">
                    <div class="bg-blue-600 text-white p-2 rounded-lg font-bold">SIP</div>
                    <span class="font-semibold text-lg text-slate-700">Perpustakaan Digital</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-sm text-right hidden sm:block">
                        <p class="font-medium text-slate-900">{{ Auth::user()->nama }}</p>
                        <p class="text-xs text-slate-500 uppercase tracking-wider">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="h-8 w-px bg-slate-200 mx-2"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs bg-slate-100 hover:bg-rose-50 hover:text-rose-600 px-4 py-2 rounded transition font-medium">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'books' }">

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        @if(Auth::user()->role === 'petugas')
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <p class="text-xs text-slate-500 uppercase font-semibold">Total Koleksi</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $stats['total_judul'] }} <span class="text-sm font-normal text-slate-500">Judul</span></h3>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <p class="text-xs text-slate-500 uppercase font-semibold">Total Kategori</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $stats['total_kategori'] }} <span class="text-sm font-normal text-slate-500">Jenis</span></h3>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <p class="text-xs text-slate-500 uppercase font-semibold">Sedang Dipinjam</p>
                <h3 class="text-2xl font-bold text-blue-600">{{ $stats['sedang_dipinjam'] }} <span class="text-sm font-normal text-slate-500">Buku</span></h3>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <p class="text-xs text-slate-500 uppercase font-semibold">Denda Masuk</p>
                <h3 class="text-2xl font-bold text-emerald-600">Rp {{ number_format($stats['total_denda'], 0, ',', '.') }}</h3>
            </div>
        </div>
        @endif

        <div class="flex items-center justify-between border-b border-slate-200 mb-6">
            <div class="flex gap-4">
                <button @click="activeTab = 'books'" :class="{ 'border-b-2 border-blue-600 text-blue-600': activeTab === 'books', 'text-slate-500 hover:text-slate-700': activeTab !== 'books' }" class="pb-3 px-1 font-medium text-sm transition">Koleksi Buku</button>
                @if(Auth::user()->role === 'petugas')
                <button @click="activeTab = 'members'" :class="{ 'border-b-2 border-blue-600 text-blue-600': activeTab === 'members', 'text-slate-500 hover:text-slate-700': activeTab !== 'members' }" class="pb-3 px-1 font-medium text-sm transition">Data Anggota</button>
                <button @click="activeTab = 'categories'" :class="{ 'border-b-2 border-blue-600 text-blue-600': activeTab === 'categories', 'text-slate-500 hover:text-slate-700': activeTab !== 'categories' }" class="pb-3 px-1 font-medium text-sm transition">Kategori</button>
                @endif
            </div>
            @if(Auth::user()->role === 'petugas')
            <a href="{{ route('reports.index') }}" class="text-sm font-medium text-slate-500 hover:text-blue-600 flex items-center gap-1 pb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Laporan
            </a>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div x-show="activeTab === 'books'" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center bg-slate-50 gap-4">
                        <h2 class="font-semibold text-slate-800">Daftar Buku</h2>
                        <form action="{{ route('dashboard') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
                            <select name="category_id" class="text-xs rounded border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="search" placeholder="Cari judul..." value="{{ request('search') }}" class="text-xs rounded border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 flex-1">
                            <button type="submit" class="bg-slate-800 text-white px-3 py-1 rounded text-xs">Cari</button>
                        </form>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-3 font-medium">Buku</th>
                                    <th class="px-6 py-3 font-medium">Kategori</th>
                                    <th class="px-6 py-3 font-medium text-center">Stok</th>
                                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($books as $book)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-900">{{ $book->judul }}</div>
                                        <div class="text-slate-500 text-xs mt-0.5">{{ $book->kode_buku }} • {{ $book->penulis }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded text-[10px] uppercase font-bold">
                                            {{ $book->category ? $book->category->nama_kategori : 'Umum' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $book->stok > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">{{ $book->stok }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if(Auth::user()->role === 'anggota')
                                            @if($book->stok > 0)
                                            <form action="{{ route('borrow.store') }}" method="POST" class="inline">
                                                @csrf <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                <button type="submit" class="text-blue-600 hover:text-blue-800 font-medium text-xs">Pinjam</button>
                                            </form>
                                            @else <span class="text-slate-400 text-xs">Habis</span> @endif
                                        @else
                                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Hapus?');">
                                                @csrf @method('DELETE')
                                                <button class="text-rose-600 hover:text-rose-800 text-xs font-medium">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-6 py-8 text-center text-slate-500 text-sm">Tidak ada buku.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if(Auth::user()->role === 'petugas')
                <div x-show="activeTab === 'members'" style="display: none;" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50"><h2 class="font-semibold text-slate-800">Manajemen Anggota</h2></div>
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                            <tr><th class="px-6 py-3">Nama</th><th class="px-6 py-3">Kontak</th><th class="px-6 py-3 text-right">Aksi</th></tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($members as $member)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4"><div class="font-medium text-slate-900">{{ $member->nama }}</div><div class="text-xs text-slate-500">{{ $member->email }}</div></td>
                                <td class="px-6 py-4"><div class="text-slate-900">{{ $member->no_telepon }}</div><div class="text-xs text-slate-500 truncate max-w-[150px]">{{ $member->alamat }}</div></td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Hapus?');">
                                        @csrf @method('DELETE') <button class="text-rose-600 hover:text-rose-800 text-xs font-medium">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div x-show="activeTab === 'categories'" style="display: none;" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                        <h2 class="font-semibold text-slate-800">Kategori Buku</h2>
                        <form action="{{ route('categories.store') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="nama_kategori" placeholder="Nama Kategori Baru" class="text-xs rounded border-slate-300 focus:border-blue-500" required>
                            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-medium">Tambah</button>
                        </form>
                    </div>
                    <div class="p-6 grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($categories as $cat)
                        <div class="flex justify-between items-center bg-slate-50 border border-slate-200 rounded-lg p-3">
                            <span class="text-sm font-medium text-slate-700">{{ $cat->nama_kategori }}</span>
                            <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');">
                                @csrf @method('DELETE')
                                <button class="text-rose-500 hover:text-rose-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div class="space-y-6">
                @if(Auth::user()->role === 'petugas')
                    <div x-show="activeTab === 'books'" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="font-semibold text-slate-800 mb-4">Tambah Buku</h3>
                        <form action="{{ route('books.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="text" name="kode_buku" placeholder="Kode Buku" class="w-full rounded-lg border-slate-300 text-sm" required>
                            <input type="text" name="judul" placeholder="Judul Buku" class="w-full rounded-lg border-slate-300 text-sm" required>

                            <select name="category_id" class="w-full rounded-lg border-slate-300 text-sm" required>
                                <option value="">- Pilih Kategori -</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                                @endforeach
                            </select>

                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" name="penulis" placeholder="Penulis" class="w-full rounded-lg border-slate-300 text-sm" required>
                                <input type="number" name="tahun_terbit" placeholder="Tahun" class="w-full rounded-lg border-slate-300 text-sm" required>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" name="penerbit" placeholder="Penerbit" class="w-full rounded-lg border-slate-300 text-sm" required>
                                <input type="number" name="stok" placeholder="Stok" class="w-full rounded-lg border-slate-300 text-sm" required>
                            </div>
                            <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-medium py-2 rounded-lg text-sm transition">Simpan</button>
                        </form>
                    </div>

                    <div x-show="activeTab === 'members'" style="display: none;" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="font-semibold text-slate-800 mb-4">Registrasi Anggota</h3>
                        <form action="{{ route('members.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="text" name="nama" placeholder="Nama Lengkap" class="w-full rounded-lg border-slate-300 text-sm" required>
                            <input type="email" name="email" placeholder="Email" class="w-full rounded-lg border-slate-300 text-sm" required>
                            <input type="password" name="password" placeholder="Password" class="w-full rounded-lg border-slate-300 text-sm" required>
                            <input type="text" name="no_telepon" placeholder="No Telp" class="w-full rounded-lg border-slate-300 text-sm" required>
                            <textarea name="alamat" placeholder="Alamat" class="w-full rounded-lg border-slate-300 text-sm" rows="2" required></textarea>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg text-sm transition">Daftar Anggota</button>
                        </form>
                    </div>
                @endif

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50"><h3 class="font-semibold text-slate-800">{{ Auth::user()->role === 'petugas' ? 'Aktivitas Peminjaman' : 'Buku Saya' }}</h3></div>
                    <div class="divide-y divide-slate-100 max-h-[400px] overflow-y-auto">
                        @forelse($borrowings as $borrow)
                            <div class="p-4 hover:bg-slate-50 transition">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="text-sm font-medium text-slate-900">{{ $borrow->book->judul }}</h4>
                                        <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($borrow->tanggal_pinjam)->format('d M') }}</p>
                                        @if(Auth::user()->role === 'petugas') <p class="text-xs text-blue-600 mt-1">{{ $borrow->user->nama }}</p> @endif
                                    </div>
                                    <div class="text-right">
                                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $borrow->status === 'DIPINJAM' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600' }}">{{ $borrow->status }}</span>
                                        @if($borrow->denda > 0) <p class="text-[10px] text-rose-600 font-bold mt-1">Rp{{ number_format($borrow->denda, 0, ',', '.') }}</p> @endif
                                    </div>
                                </div>
                                @if($borrow->status === 'DIPINJAM')
                                    <form action="{{ route('borrow.return', $borrow->id) }}" method="POST" class="mt-2">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium py-1.5 rounded transition">{{ Auth::user()->role === 'petugas' ? 'Terima Kembali' : 'Kembalikan' }}</button>
                                    </form>
                                @endif
                            </div>
                        @empty
                            <div class="p-4 text-center text-xs text-slate-400">Belum ada aktivitas.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
