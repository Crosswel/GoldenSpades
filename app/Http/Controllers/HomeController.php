<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class HomeController extends Controller
{
    public function index()
    {
        $produtos = \App\Models\Produto::all();

        $produtosPorCategoria = $produtos->groupBy(function($produto) {
            return ucfirst($produto->categoria);
        });

        return view('home', compact('produtosPorCategoria'));
    }


    public function categoria($categoria)
    {
        $produtos = Produto::where('categoria', $categoria)->paginate(12);
        return view('categoria', compact('produtos', 'categoria'));
    }


    public function novaColecao()
    {
        $now = now();

        $produtos = Produto::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->get();

            // agrupar por categoria
        $produtosPorCategoria = $produtos->groupBy('categoria');

        return view('novacolecao', compact('produtosPorCategoria'));
    }


}
