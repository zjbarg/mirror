<?php

namespace Mirror\Infrastructure\Data;

use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Mirror\Core\Accounts\Entities\User;
use Mirror\Core\Accounts\UsersRepository;

class DataServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(UsersRepository::class, fn() => EntityManager::getRepository(User::class));
    }
}
