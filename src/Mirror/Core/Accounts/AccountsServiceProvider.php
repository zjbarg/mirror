<?php

namespace Mirror\Core\Accounts;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AccountsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Event::listen(RegisteredEvent::class, SendWelcomeEmailListener::class);
    }
}
