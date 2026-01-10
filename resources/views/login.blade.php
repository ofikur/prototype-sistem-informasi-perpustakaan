<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sistem Informasi Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center">

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg border border-slate-100 p-8">
        <div class="text-center mb-8">
            <div class="inline-flex bg-blue-600 text-white p-3 rounded-xl font-bold text-xl mb-4">SIP</div>
            <h1 class="text-2xl font-bold text-slate-800">Selamat Datang</h1>
            <p class="text-slate-500 mt-2 text-sm">Silakan pilih metode masuk untuk melanjutkan ke dashboard perpustakaan.</p>
        </div>

        <div class="space-y-4">
            <a href="{{ route('login.admin') }}" class="block w-full group">
                <div class="border border-slate-200 rounded-lg p-4 hover:border-blue-500 hover:bg-blue-50 transition flex items-center gap-4">
                    <div class="bg-blue-100 p-3 rounded-full text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-800">Masuk sebagai Petugas</h3>
                        <p class="text-xs text-slate-500">Akses penuh pengelolaan buku</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('login.member') }}" class="block w-full group">
                <div class="border border-slate-200 rounded-lg p-4 hover:border-emerald-500 hover:bg-emerald-50 transition flex items-center gap-4">
                    <div class="bg-emerald-100 p-3 rounded-full text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-800">Masuk sebagai Anggota</h3>
                        <p class="text-xs text-slate-500">Peminjaman dan pengembalian</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="mt-8 text-center border-t border-slate-100 pt-6">
            <p class="text-xs text-slate-400">Prototype Sistem Berorientasi Objek</p>
        </div>
    </div>

</body>
</html>
