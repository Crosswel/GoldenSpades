<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\CarrinhoController;

/**
 * Página inicial
 */
Route::get('/', [HomeController::class, 'index'])->name('home');

/**
 * Páginas públicas
 */
Route::view('/dbconn', 'dbconn');
Route::view('/favoritos', 'favoritos')->name('favoritos');
Route::get('/novacolecao', [HomeController::class, 'novaColecao'])->name('novacolecao');
Route::get('/faqs', fn() => view('faqs'))->name('faqs');

/**
 * Pesquisa e produtos
 */
Route::get('/relogios', [ProdutoController::class, 'relogios'])->name('relogios');
Route::get('/pesquisar', [ProdutoController::class, 'pesquisar'])->name('produtos.pesquisar');
Route::get('/search', [ProdutoController::class, 'search'])->name('search');

/**
 * Protegido (todos autenticados)
 */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::post('/dashboard/update', [UserController::class, 'updateProfile'])->name('dashboard.update');
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    Route::post('/products', [ProdutoController::class, 'store'])->name('products.store');

    /**
     * Admin-only
     */
    Route::middleware(['can:isAdmin'])->group(function () {
        Route::get('/admin/products', [ProductManagementController::class, 'index'])->name('products.index');
        Route::get('/admin/products/{product}/edit', [ProductManagementController::class, 'edit'])->name('products.edit');
        Route::put('/admin/products/{product}', [ProductManagementController::class, 'update'])->name('products.update');
        Route::delete('/admin/products/{product}', [ProductManagementController::class, 'destroy'])->name('products.destroy');
    });
});

/**
 * Outros
 */
Route::get('/admin', fn() => view('admin.dashboard'))
    ->middleware(['auth', 'can:isAdmin'])
    ->name('admin.dashboard');

Route::get('/categoria/{categoria}', [HomeController::class, 'categoria'])->name('categoria');
Route::get('/produto/{id}', [ProdutoController::class, 'show'])->name('produto');

/**
 * Carrinho
 */
Route::post('/cart/add', [CarrinhoController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CarrinhoController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CarrinhoController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CarrinhoController::class, 'clear'])->name('cart.clear');

/**
 * Checkout
 */
Route::get('/checkout', [CarrinhoController::class, 'checkout'])->name('checkout');
Route::post('/checkout/endereco', [CarrinhoController::class, 'processarEndereco'])->name('checkout.endereco');
Route::get('/checkout/pagamento', [CarrinhoController::class, 'pagamento'])->name('checkout.pagamento');
Route::post('/checkout/finalizar', [CarrinhoController::class, 'finalizar'])->name('checkout.finalizar');

/**
 * Pedidos
 */
Route::post('/pedido/finalizar', function() {
    session()->forget('carrinho');
    return redirect()->route('home')->with('success', 'Pedido realizado com sucesso!');
})->name('pedido.finalizar');

/**
 * Admin pedidos
 */
Route::patch('/admin/orders/{order}', [\App\Http\Controllers\AdminOrderController::class, 'update'])->name('admin.orders.update');
