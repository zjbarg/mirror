<?php

namespace Mirror\Infrastructure\Data;

use DebugBar\Bridge\DoctrineCollector;
use Doctrine\DBAL\Logging\DebugStack;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Mirror\Core\Accounts\Contracts\UsersRepository;
use Mirror\Infrastructure\Data\Accounts\DoctrineUsersRepository;

class DataServiceProvider extends ServiceProvider
{
    // public function boot(): void
    // {
    //     $debugStack = new DebugStack();
    //     EntityManager::getConnection()->getConfiguration()->setSQLLogger($debugStack);
    //     $debugbar = App::make('debugbar');
    //     $debugbar->addCollector(new DoctrineCollector($debugStack));
    // }

    public function register(): void
    {
        $this->app->singleton(UsersRepository::class, DoctrineUsersRepository::class);
    }
}
