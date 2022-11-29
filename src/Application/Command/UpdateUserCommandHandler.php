<?php

namespace App\Application\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UpdateUserCommandHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function handle(UpdateUserCommand $command, User $user): User
    {
        $user->setFirstName($command->firstName);
        $user->setLastName($command->lastName);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
