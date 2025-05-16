<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\HomeController;

/**
 * Página inicial
 */
Route::get('/', [HomeController::class, 'index'])->name('home');

/**
 * Páginas públicas
 */
Route::get('/dbconn', function () {
    return view('dbconn');
});

Route::get('/favoritos', function () {
    return view('favoritos');
})->name('favoritos');

Route::get('/novacolecao', function () {
    return view('novacolecao');
})->name('novacolecao');

Route::get('/produto', function () {
    return view('produto');
})->name('produto');

/**
 * Pesquisa e produtos
 */
Route::get('/relogios', [ProdutoController::class, 'relogios'])->name('relogios');
Route::get('/pesquisar', [ProdutoController::class, 'pesquisar'])->name('produtos.pesquisar');
Route::get('/search', [ProdutoController::class, 'search'])->name('search');

/**
 * Áreas protegidas por autenticação
 */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
});

Route::get('/admin', function () {
    return view('admin.dashboard'); // ou o ficheiro Blade que preferires
})->middleware(['auth'])->name('admin.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});
