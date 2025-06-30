<?php

namespace App\Http\Controllers\Auth;

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as FortifyAuthenticatedSessionController;

class AuthenticatedSessionController extends FortifyAuthenticatedSessionController
{
    public function store(\Laravel\Fortify\Http\Requests\LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        return redirect('/'); // força a home
    }
}

