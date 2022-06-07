<?php

namespace Mirror\Infrastructure\Data\Accounts;

use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\Event;
use Mirror\Core\Accounts\UsersRepository;
use Mirror\Core\Accounts\Entities\User;

class DoctrineUsersRepository extends EntityRepository implements UsersRepository
{
    public function findById(int $id): ?User
    {
        return parent::find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return parent::findBy(
            criteria: ['email' => $email],
            limit: 1,
        )[0];
    }

    public function save(User ...$user): void
    {
        foreach ($user as $single) {
            $this->getEntityManager()->persist($single);
        }

        $this->getEntityManager()->flush();

        foreach ($user as $single) {
            $events = $single->dequeueDomainEvents();
            array_walk($events, fn($event) => Event::dispatch($event));
        }
    }
}
