<?php

namespace Mirror\Infrastructure\Data\Accounts;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Mirror\Core\Accounts\Entities\User;

class UserMapping extends EntityMapping
{
    public function mapFor(): string
    {
        return User::class;
    }

    public function map(Fluent $builder): void
    {
        $builder->table('users');
        $builder->increments('id')->primary();
        $builder->string('name');
        $builder->string('email')->unique();
        $builder->string('password');
        $builder->rememberToken('remember_token')->nullable();
        $builder->timestamps('created_at', 'updated_at', 'carbondatetime');
    }
}
