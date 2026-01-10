<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/auth/admin', function () {
    Auth::loginUsingId(1);
    return redirect()->route('dashboard');
})->name('login.admin');

Route::get('/auth/member', function () {
    Auth::loginUsingId(2);
    return redirect()->route('dashboard');
})->name('login.member');

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('dashboard');

    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

    Route::post('/borrow', [BorrowingController::class, 'store'])->name('borrow.store');
    Route::patch('/return/{borrowing}', [BorrowingController::class, 'returnBook'])->name('borrow.return');

    Route::post('/members', [MemberController::class, 'store'])->name('members.store');
    Route::delete('/members/{user}', [MemberController::class, 'destroy'])->name('members.destroy');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    Route::post('/categories', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');
});
