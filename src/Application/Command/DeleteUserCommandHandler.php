<?php

namespace App\Application\Command;

use Doctrine\ORM\EntityManagerInterface;

class DeleteUserCommandHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function handle(DeleteUserCommand $command): void
    {
        $this->entityManager->remove($command->user);
        $this->entityManager->flush();
    }
}
