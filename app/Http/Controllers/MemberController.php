<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'alamat' => 'required',
            'no_telepon' => 'required'
        ]);

        User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'alamat' => $validated['alamat'],
            'no_telepon' => $validated['no_telepon'],
            'role' => 'anggota'
        ]);

        return back()->with('success', 'Anggota baru berhasil didaftarkan.');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'anggota') {
            return back()->with('error', 'Tidak dapat menghapus data petugas.');
        }

        $user->delete();
        return back()->with('success', 'Data anggota berhasil dihapus.');
    }
}
