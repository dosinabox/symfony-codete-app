<?php

namespace App\Application\Command;

use App\Application\Query\GetUserByIDQuery;
use App\Application\Query\GetUserByIDQueryHandler;
use Doctrine\ORM\EntityManagerInterface;

class DeleteUserCommandHandler
{
    public function __construct(
        private readonly GetUserByIDQueryHandler $queryHandler,
        private readonly EntityManagerInterface $entityManager)
    {
    }

    public function handle(DeleteUserCommand $command): void
    {
        $user = $this->queryHandler->handle(new GetUserByIDQuery($command->id));

        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
