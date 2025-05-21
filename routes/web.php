<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserController;

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

    // Painel do utilizador com favoritos, encomendas, etc.
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // Atualização de dados do perfil pelo próprio utilizador
    Route::post('/dashboard/update', [UserController::class, 'updateProfile'])->name('dashboard.update');

    // Página dedicada de perfil
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
});

// Área de administração
Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('admin.dashboard');
