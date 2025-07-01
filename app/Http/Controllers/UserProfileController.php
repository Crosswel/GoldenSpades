<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Mostrar o formulário de edição do perfil.
     */
    public function edit(Request $request)
    {
        $user = Auth::user();

        if ($user->usertype == 0) {
            $query = Produto::query();
            if ($request->has('categories')) {
                $categories = explode(',', $request->categories);
                $query->whereIn('categoria', $categories);
            }
            $products = $query->get();
            $categories = Produto::select('categoria')->distinct()->pluck('categoria');

            $orders = Order::with(['items.produto', 'user'])->latest()->get();

            if ($request->ajax()) {
                return view('partials.product_list', compact('products'))->render();
            }

            return view('profile.edit', compact('user','products','orders','categories'));
        }

        // normal user
        $orders = Order::with(['items.produto'])->where('user_id', $user->id)->latest()->get();
        return view('profile.edit', [
            'user' => $user,
            'products' => [],
            'orders' => $orders,
            'categories' => collect()
        ]);
    }



    /**
     * Atualizar os dados do perfil do usuário.
     */
    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function historico()
    {
        $historico = session('historico', []);
        return view('profile.historico', compact('historico'));
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        // apenas admins podem ver
        if ($user->usertype != 0) {
            abort(403);
        }

        $query = Produto::query();

        if ($request->has('categories')) {
            $query->whereIn('categoria', $request->categories);
        }

        $products = $query->get();

        $categories = Produto::select('categoria')->distinct()->pluck('categoria');

        $orders = Order::with(['items.produto', 'user'])->latest()->get();

        // se for ajax, devolver apenas o HTML do product-list
        if ($request->ajax()) {
            $query = Produto::query();

            if ($request->has('categories')) {
                $query->whereIn('categoria', $request->categories);
            }

            $products = $query->get();

            // renderiza apenas o partial
            return view('partials.product_list', compact('products'))->render();
        }

    }



}