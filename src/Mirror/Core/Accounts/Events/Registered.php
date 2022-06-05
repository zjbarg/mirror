<?php

namespace Mirror\Core\Accounts\Events;

use Mirror\Core\Accounts\Entities\User;
use Mirror\Core\Contracts\DomainEvent;

class Registered implements DomainEvent
{
    public function __construct(
        public readonly User $user,
    )
    {
    }
}
