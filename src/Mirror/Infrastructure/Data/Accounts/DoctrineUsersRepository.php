<?php

namespace Mirror\Infrastructure\Data\Accounts;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\Event;
use Mirror\Core\Accounts\Contracts\UsersRepository;
use Mirror\Core\Accounts\Entities\User;

class DoctrineUsersRepository extends EntityRepository implements UsersRepository
{
    public function __construct(
        private readonly EntityManagerInterface $entity_manager,
    )
    {
    }

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

    public function save(User $user): void
    {
        $this->entity_manager->persist($user);
        $this->entity_manager->flush();

        $events = $user->dequeueDomainEvents();

        foreach ($events as $event) {
            Event::dispatch($event);
        }
    }
}
