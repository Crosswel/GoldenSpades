<?php

namespace App\Http\Controllers;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Mostrar o formulário de edição do perfil.
     */
    public function edit()
    {
        $user = Auth::user();
        $orders = $user->orders;
        $products = Produto::all();
        return view('profile.edit', [
            'user' => $user,
            'orders' => $orders,
            'products' => $products,
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
}
