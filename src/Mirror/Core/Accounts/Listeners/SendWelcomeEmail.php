<?php

namespace Mirror\Core\Accounts\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Mirror\Core\Accounts\Events\Registered;
use Mirror\Core\Accounts\Notifications\WelcomeEmail;

class SendWelcomeEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(Registered $event): void
    {
        Notification::send($event->user, new WelcomeEmail);
    }
}
