<?php

namespace App\Application\Command;

use App\Entity\User;
use App\Application\Query\GetUserByIDQuery;
use App\Application\Query\GetUserByIDQueryHandler;
use Doctrine\ORM\EntityManagerInterface;

class UpdateUserCommandHandler
{
    public function __construct(
        private readonly GetUserByIDQueryHandler $queryHandler,
        private readonly EntityManagerInterface $entityManager)
    {
    }

    public function handle(UpdateUserCommand $command): User
    {
        $user = $this->queryHandler->handle(new GetUserByIDQuery($command->id));
        $user->setFirstName($command->firstName);
        $user->setLastName($command->lastName);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
