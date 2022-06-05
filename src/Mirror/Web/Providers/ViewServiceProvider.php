<?php

namespace Mirror\Web\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Mirror\Web\View\Components\AppLayout;
use Mirror\Web\View\Components\GuestLayout;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blade::component('app-layout', AppLayout::class);
        Blade::component('guest-layout', GuestLayout::class);
    }
}
