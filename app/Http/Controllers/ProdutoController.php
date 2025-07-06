<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{


    // Listar admin
    public function index()
    {
        $produtos = Produto::all();
        return view('admin.produtos.index', compact('produtos'));
    }

    // Mostrar formulário de criação
    public function create()
    {
        return view('admin.produtos.create');
    }

    // Guardar novo
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0',
            'imagem' => 'nullable|image|max:2048',
        ]);

        $imagemPath = null;

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

        Produto::create([
            'nome' => $request->nome,
            'categoria' => $request->categoria,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'quantidade' => $request->quantidade,
            'imagem' => $imagemPath,
        ]);

        return redirect()->route('profile.edit')->with('success', 'Produto criado com sucesso!');
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
            'imagem' => 'nullable|image|max:2048',
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
            $data['imagem'] = $imagemPath;
        }

        $product->update($data);

        return redirect()->route('profile.edit')->with('success', 'Produto atualizado com sucesso!');
    }

    // Eliminar
    public function destroy(Produto $product)
    {
        $product->delete();
        return redirect()->route('profile.edit')->with('success', 'Produto eliminado com sucesso!');
    }

    // Página do produto
    public function show($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produto', compact('produto'));
    }

    // Pesquisa (continua igual)
    public function search(Request $request)
    {
        $query = $request->input('query');

        $produtos = Produto::where('nome', 'like', '%' . $query . '%')
                            ->orWhere('descricao', 'like', '%' . $query . '%')
                            ->orWhere('categoria', 'like', '%' . $query . '%')
                            ->get();

        // resposta AJAX
        if ($request->ajax()) {
            return view('partials.products', compact('produtos'))->render();
        }

        // resposta normal
        return view('search_results', compact('produtos'));
    }


    


}
