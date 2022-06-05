<?php

namespace Mirror\Core\Accounts\Contracts;

use Mirror\Core\Accounts\Entities\User;

interface UsersRepository
{
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function save(User $user): void;
}
