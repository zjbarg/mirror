<?php

namespace Mirror\Core\Accounts\Events;

use Mirror\Core\Contracts\DomainEvent;
use Mirror\Core\Accounts\Entities\User;

class PasswordReset implements DomainEvent
{
    public function __construct(
        public readonly User $user,
    )
    {
    }
}
