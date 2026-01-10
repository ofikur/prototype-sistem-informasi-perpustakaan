<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required|unique:categories,nama_kategori']);

        Category::create($request->all());

        return back()->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
