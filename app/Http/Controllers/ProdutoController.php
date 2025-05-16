<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function relogios()
    {
        $produtos = Produto::where('categoria', 'Relógios')->get();

        return view('relogios', compact('produtos'));
    }

    public function search(Request $request)
{
    $query = $request->input('query');

    $produtos = Produto::where('nome', 'like', '%' . $query . '%')->get();

    return view('search_results', compact('produtos'));
}

}

use App\Http\Controllers\ProdutoController;

Route::get('/favoritos', [ProdutoController::class, 'favoritos'])->name('favoritos');
