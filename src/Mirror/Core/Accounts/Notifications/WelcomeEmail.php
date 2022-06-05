<?php

namespace Mirror\Core\Accounts\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Mirror\Core\Accounts\Entities\User;

class WelcomeEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via(User $user): array
    {
        return ['mail'];
    }


    public function toMail(User $user): MailMessage
    {
        return (new MailMessage)
                    ->subject('Welcome')
                    ->greeting('Hello, ' . $user->getName())
                    ->line('Thank you for registering with us.');
    }
}
