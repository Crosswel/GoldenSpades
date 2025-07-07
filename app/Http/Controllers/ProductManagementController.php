<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProductManagementController extends Controller
{
    /**
     * Lista todos os produtos
     */
    public function index()
    {
        $products = Produto::all();
        return view('admin.produtos.index', compact('products'));
    }

    /**
     * Formulário de criação de produto
     */
    public function create()
    {
        return view('admin.produtos.create');
    }

    /**
     * Armazena novo produto
     */
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
            $folder = strtolower($validated['categoria']);
            $destination = public_path("images/{$folder}");
            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }
            $fileName = time().'_'.$request->file('imagem')->getClientOriginalName();
            $request->file('imagem')->move($destination, $fileName);
            $validated['imagem'] = "images/{$folder}/{$fileName}";
        }

        Produto::create($validated);

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso.');
    }

    /**
     * Formulário de edição de produto
     */
    public function edit(Produto $product)
    {
        return view('admin.produtos.edit', compact('product'));
    }

    /**
     * Atualiza um produto
     */
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
            $folder = strtolower($validated['categoria']);
            $destination = public_path("images/{$folder}");
            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }
            $fileName = time().'_'.$request->file('imagem')->getClientOriginalName();
            $request->file('imagem')->move($destination, $fileName);
            $validated['imagem'] = "images/{$folder}/{$fileName}";
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso.');
    }

    /**
     * Apagar produto
     */
    public function destroy(Produto $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produto eliminado com sucesso.');
    }
}
