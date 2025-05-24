<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductManagementController;

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

    // Painel do utilizador
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // Atualização de perfil
    Route::post('/dashboard/update', [UserController::class, 'updateProfile'])->name('dashboard.update');

    // Página de perfil
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    // Inserção direta de novo produto pelo admin no perfil
    Route::post('/products', [ProdutoController::class, 'store'])->name('products.store');

    // Gestão de produtos (Admin - rotas completas)
    Route::middleware('can:isAdmin')->group(function () {
        Route::get('/admin/products', [ProductManagementController::class, 'index'])->name('products.index');
        Route::get('/admin/products/create', [ProductManagementController::class, 'create'])->name('products.create');
        Route::post('/admin/products', [ProductManagementController::class, 'store'])->name('products.store.alt');
        Route::get('/admin/products/{product}/edit', [ProductManagementController::class, 'edit'])->name('products.edit');
        Route::put('/admin/products/{product}', [ProductManagementController::class, 'update'])->name('products.update');
        Route::delete('/admin/products/{product}', [ProductManagementController::class, 'destroy'])->name('products.destroy');
    });
});

// Área de administração
Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('admin.dashboard');
