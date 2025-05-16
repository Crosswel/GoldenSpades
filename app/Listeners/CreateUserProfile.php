<?php

namespace App\Listeners;

use App\Models\Profile;
use Illuminate\Auth\Events\Registered;

class CreateUserProfile
{
    /**
     * Lida com o evento de registo e cria o perfil do utilizador.
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;

        // Verifica se o utilizador já tem perfil (evita duplicação)
        if (!$user->profile) {
            $user->profile()->create([
                'address' => '',
                'phone' => '',
            ]);
        }
    }
}
