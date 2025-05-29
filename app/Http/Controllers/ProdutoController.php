<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    // Produtos da categoria Relógios
    public function relogios()
    {
        $produtos = Produto::where('categoria', 'Relógios')->get();
        return view('relogios', compact('produtos'));
    }

    // Pesquisa por nome
    public function search(Request $request)
    {
        $query = $request->input('query');
        $produtos = Produto::where('nome', 'like', '%' . $query . '%')->get();
        return view('search_results', compact('produtos'));
    }

    // Listagem de produtos (admin)
    public function index()
    {
        $produtos = Produto::all();
        return view('admin.produtos.index', compact('produtos'));
    }

    // Formulário de criação
    public function create()
    {
        return view('admin.produtos.create');
    }

    // Armazenar novo produto
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagemPath = null;
        if ($request->hasFile('imagem')) {
            $imagemPath = $request->file('imagem')->store('produtos', 'public');
        }

        Produto::create([
            'nome' => $request->nome,
            'categoria' => $request->categoria,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'imagem' => $imagemPath,
        ]);

        return redirect()->route('profile')->with('success', 'Produto adicionado com sucesso.');
    }


    // Editar produto
    public function edit(Produto $product)
    {
        return view('admin.produtos.edit', compact('product'));
    }

    // Atualizar produto
    public function update(Request $request, Produto $product)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['nome', 'categoria', 'descricao', 'preco']);

        if ($request->hasFile('imagem')) {
            // Eliminar imagem antiga se existir
            if ($product->imagem && Storage::disk('public')->exists($product->imagem)) {
                Storage::disk('public')->delete($product->imagem);
            }
            $data['imagem'] = $request->file('imagem')->store('produtos', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso.');
    }

    // Eliminar produto
    public function destroy(Produto $product)
    {
        // Eliminar imagem associada se existir
        if ($product->imagem && Storage::disk('public')->exists($product->imagem)) {
            Storage::disk('public')->delete($product->imagem);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produto eliminado com sucesso.');
    }
}
