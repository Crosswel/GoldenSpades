<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * O caminho para onde os utilizadores são redirecionados após login.
     *
     * @var string
     */
    public const HOME = '/';


    /**
     * Define o redirecionamento pós-login baseado no tipo de utilizador.
     */
    protected function redirectTo()
    {
        $user = auth()->user();

        if ($user->usertype == 0) {
            return '/admin';
        }

        return self::HOME;
    }

    /**
     * Define as rotas da aplicação.
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Define limites de acesso (rate limiting).
     */
    protected function configureRateLimiting()
    {
        // Podes configurar limites de requisições aqui, se necessário.
    }
}
