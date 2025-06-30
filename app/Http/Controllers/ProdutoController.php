<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    // Produtos por categoria exemplo
    public function relogios()
    {
        $produtos = Produto::where('categoria', 'Relógios')->get();
        return view('relogios', compact('produtos'));
    }

    // Pesquisa
    public function search(Request $request)
    {
        $query = $request->input('query');
        $produtos = Produto::where('nome', 'like', '%' . $query . '%')->get();
        return view('search_results', compact('produtos'));
    }

    // Listagem admin
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
            'quantidade' => 'required|integer|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagemPath = null;

        if ($request->hasFile('imagem')) {
            $categoriaFolder = strtolower($request->categoria);

            $destinationPath = public_path("images/{$categoriaFolder}");
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $nomeImagem = time() . '_' . $request->file('imagem')->getClientOriginalName();
            $request->file('imagem')->move($destinationPath, $nomeImagem);

            $imagemPath = "images/{$categoriaFolder}/{$nomeImagem}";
        }

        $produto = Produto::create([
            'nome' => $request->nome,
            'categoria' => $request->categoria,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'quantidade' => $request->quantidade,
            'imagem' => $imagemPath,
        ]);

        if ($request->ajax()) {
            return response()->json($produto);
        }

        return redirect()->route('profile')->with('success', 'Produto adicionado com sucesso.');
    }

    // Editar
    public function edit(Produto $product)
    {
        return view('admin.produtos.edit', compact('product'));
    }

    // Atualizar
    public function update(Request $request, Produto $product)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['nome', 'categoria', 'descricao', 'preco', 'quantidade']);

        if ($request->hasFile('imagem')) {
            $categoriaFolder = strtolower($request->categoria);
            $destinationPath = public_path("images/{$categoriaFolder}");

        if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0777, true);
        }

        $nomeImagem = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $request->file('imagem')->getClientOriginalName());
        $request->file('imagem')->move($destinationPath, $nomeImagem);

        $imagemPath = "images/{$categoriaFolder}/{$nomeImagem}";
    }


        $product->update($data);

        return redirect()->route('profile')->with('success', 'Produto atualizado com sucesso.');
    }

    // Eliminar
    public function destroy(Produto $product)
    {
        $product->delete();
        return redirect()->route('profile')->with('success', 'Produto eliminado com sucesso.');
    }

public function show($id)
{
    $produto = Produto::findOrFail($id);
    return view('produto', compact('produto'));
}




}
