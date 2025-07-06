<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

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
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0',
            'imagem' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagem')) {
            $categoriaFolder = strtolower($validated['categoria']);
            $destinationPath = public_path("images/{$categoriaFolder}");
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $nomeImagem = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $request->file('imagem')->getClientOriginalName());
            $request->file('imagem')->move($destinationPath, $nomeImagem);
            $validated['imagem'] = "images/{$categoriaFolder}/{$nomeImagem}";
        }

        Produto::create($validated);

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
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0',
            'imagem' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagem')) {
            $categoriaFolder = strtolower($validated['categoria']);
            $destinationPath = public_path("images/{$categoriaFolder}");
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $nomeImagem = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $request->file('imagem')->getClientOriginalName());
            $request->file('imagem')->move($destinationPath, $nomeImagem);
            $validated['imagem'] = "images/{$categoriaFolder}/{$nomeImagem}";
        }

        $product->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Produto atualizado com sucesso!');
    }

    // Eliminar
    public function destroy(Produto $product)
    {
        $product->delete();
        return redirect()->route('profile.edit')->with('success', 'Produto eliminado com sucesso!');
    }

    // Página de produto
    public function show($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produto', compact('produto'));
    }

    // Pesquisa (usada globalmente)
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return redirect()->back()->with('error', 'Introduza um termo de pesquisa.');
        }

        $produtos = Produto::where('nome', 'like', "%{$query}%")
            ->orWhere('descricao', 'like', "%{$query}%")
            ->orWhere('categoria', 'like', "%{$query}%")
            ->get();

        // resposta AJAX se vier do live search
        if ($request->ajax()) {
            return view('partials.products', compact('produtos'))->render();
        }

        // resposta tradicional
        return view('search_results', compact('produtos'));
    }
}
