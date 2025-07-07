<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Produto;
use App\Policies\ProdutoPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Produto::class => ProdutoPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function($user) {
            \Log::info('GATE isAdmin usertype=' . $user->usertype);  // debug
            return $user->usertype == "0";
        });
    }
}
