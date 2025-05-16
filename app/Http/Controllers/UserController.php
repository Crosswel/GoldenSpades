<?php

namespace App\Http\Controllers;

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

        // Certifica-te de que estas relações existem no modelo User
        $orders = $user->orders ?? collect();
        $favorites = $user->favorites ?? collect();

        return view('dashboard', compact('user', 'orders', 'favorites'));
    }

    /**
     * Atualiza os dados do perfil (morada e telemóvel).
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();

        // Garante que o utilizador tem um perfil
        if (!$user->profile) {
            $user->profile()->create();
        }

        $user->profile->update([
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Perfil atualizado com sucesso.');
    }
}
