<?php

namespace App\Application\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CreateUserCommandHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function handle(string $firstName, string $lastName): User
    {
        $user = new User();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
