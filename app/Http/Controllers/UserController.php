<?php

namespace App\Http\Controllers;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Mostra o painel do utilizador com favoritos, encomendas e perfil.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Relações devem estar definidas no modelo User
        $orders = $user->orders ?? collect();
        $favorites = $user->favorites ?? collect();
        $produtos = Produto::all();
        return view('home', compact('user', 'orders', 'favorites', 'produtos'));
    }

    /**
     * Atualiza os dados do perfil (morada, telemóvel, e email se desejado).
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->save();

        return redirect()->route('home')->with('success', 'Perfil atualizado com sucesso.');
    }
}
