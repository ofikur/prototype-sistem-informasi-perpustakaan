<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_buku',
        'judul',
        'category_id',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function updateStok($jumlah)
    {
        $this->stok = $this->stok + $jumlah;
        $this->save();
    }
}
