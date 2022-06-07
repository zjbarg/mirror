<?php

namespace Mirror\Core\Accounts;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Mirror\Core\Accounts\Entities\User;
use Mirror\Core\Contracts\DomainEvent;

class RegisteredEvent implements DomainEvent
{
    use InteractsWithSockets;
    use Dispatchable;

    public function __construct(
        public readonly User $user,
    )
    {
    }
}
