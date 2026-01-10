<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Ofik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10 font-sans">

    <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-2xl">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">📚 Wangsheng Library</h1>
                <p class="text-gray-500">Prototype Sistem Berorientasi Objek (Class-Based Design)</p>
            </div>
            <div class="text-right">
                <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded">User: Ofik (Anggota)</span>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative">
                <strong class="font-bold">Hore! 🎉</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative">
                <strong class="font-bold">Aiyaa! 😱</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Judul Buku</th>
                        <th class="px-6 py-3">Penulis</th>
                        <th class="px-6 py-3 text-center">Stok</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $book->kode_buku }}</td>
                        <td class="px-6 py-4">{{ $book->judul }}</td>
                        <td class="px-6 py-4">{{ $book->penulis }}</td>
                        <td class="px-6 py-4 text-center font-bold {{ $book->stok > 0 ? 'text-green-600' : 'text-red-500' }}">
                            {{ $book->stok }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($book->stok > 0)
                                <form action="{{ route('borrow.store') }}" method="POST">
                                    @csrf <input type="hidden" name="book_id" value="{{ $book->id }}">
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-md">
                                        Pinjam
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 italic">Habis</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
