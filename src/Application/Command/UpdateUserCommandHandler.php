<?php

namespace App\Application\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UpdateUserCommandHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function handle(UpdateUserCommand $command): User
    {
        $command->user->setFirstName($command->firstName);
        $command->user->setLastName($command->lastName);

        $this->entityManager->persist($command->user);
        $this->entityManager->flush();

        return $command->user;
    }
}
