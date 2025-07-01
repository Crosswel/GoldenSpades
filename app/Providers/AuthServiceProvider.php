<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Produto;
use App\Policies\ProdutoPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * O mapeamento das policies para a aplicação.
     *
     * @var array
     */
    protected $policies = [
        Produto::class => ProdutoPolicy::class,
    ];

    /**
     * Regista quaisquer serviços de autenticação / autorização.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', fn($user) => $user->usertype === 0);
    }
}