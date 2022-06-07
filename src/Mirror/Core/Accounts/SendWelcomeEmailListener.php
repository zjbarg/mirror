<?php

namespace Mirror\Core\Accounts;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendWelcomeEmailListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(RegisteredEvent $event): void
    {
        Notification::send($event->user, new WelcomeNotification);
        // $event->user->notifyNow(new WelcomeNotification);
    }
}
