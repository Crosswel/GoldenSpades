<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use App\Listeners\CreateUserProfile;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Os ouvintes de eventos da aplicação.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            CreateUserProfile::class,
        ],
    ];

    /**
     * Regista quaisquer eventos para a aplicação.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determina se os eventos devem ser descobertos automaticamente.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
