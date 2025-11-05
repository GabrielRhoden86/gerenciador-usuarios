<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
         \App\Models\User::class => \App\Policies\UsuarioPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

    }
}
