<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Mulyono',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'petugas',
            'jabatan' => 'Kepala Pustaka'
        ]);

        User::create([
            'nama' => 'Moh. Ofikurrahman',
            'email' => 'ofikurxyz@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'anggota',
            'alamat' => 'Pamekasan, Madura',
            'no_telepon' => '08123456789'
        ]);

        Book::create([
            'kode_buku' => 'BK-001',
            'judul' => 'Pemrograman Berorientasi Objek',
            'penulis' => 'Ofikurrahman',
            'penerbit' => 'UIM Press',
            'tahun_terbit' => 2025,
            'stok' => 5
        ]);

        Book::create([
            'kode_buku' => 'BK-002',
            'judul' => 'Cara Cepat Belajar PHP',
            'penulis' => 'Fufufafa',
            'penerbit' => 'Mulyo Media',
            'tahun_terbit' => 2023,
            'stok' => 3
        ]);

         Book::create([
            'kode_buku' => 'BK-003',
            'judul' => 'Tutorial Laravel Lengkap',
            'penulis' => 'Taylor Otwell',
            'penerbit' => 'Laravel LLC',
            'tahun_terbit' => 2024,
            'stok' => 10
        ]);
    }
}
