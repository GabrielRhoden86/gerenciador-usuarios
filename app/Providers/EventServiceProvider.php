<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        \App\Events\SolicitarResetSenha::class => [
            \App\Listeners\EnviarEmailResetSenha::class,
        ],

    ];

    public function boot(): void
    {
        parent::boot();
    }
}
