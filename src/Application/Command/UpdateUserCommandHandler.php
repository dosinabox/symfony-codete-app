<?php

namespace App\Application\Command;

use App\Entity\User;
use App\Application\Query\GetUserByIDQuery;
use App\Application\Query\GetUserByIDQueryHandler;
use App\Event\UserUpdatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class UpdateUserCommandHandler
{
    public function __construct(
        private readonly GetUserByIDQueryHandler $queryHandler,
        private readonly EntityManagerInterface $entityManager,
        private readonly EventDispatcherInterface $dispatcher)
    {
    }

    public function handle(UpdateUserCommand $command): User
    {
        $user = $this->queryHandler->handle(new GetUserByIDQuery($command->id));
        $user->setFirstName($command->firstName);
        $user->setLastName($command->lastName);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->dispatcher->dispatch(new UserUpdatedEvent($user), UserUpdatedEvent::NAME);

        return $user;
    }
}
