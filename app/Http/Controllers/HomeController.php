<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto; // Importa o modelo Produto

class HomeController extends Controller
{
    public function index()
    {
        // Buscar todos os produtos
        $produtos = Produto::all();

        // Enviar produtos para a view home
        return view('home', compact('produtos'));
    }
}
