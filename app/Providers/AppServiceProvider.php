<?php

namespace App\Providers;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Repositories\Contracts\UserRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
           // Exmplo de  modularidade troca de db  AGORA injeta o Repositório de MongoDB:   MongoDbUserRepository::class
        );
    }

    public function boot(): void
    {

    }
}
