<?php

namespace App\Application\Command;

use App\Application\Query\GetUserByIDQuery;
use App\Application\Query\GetUserByIDQueryHandler;
use App\Event\UserDeletedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly GetUserByIDQueryHandler $queryHandler,
        private readonly EntityManagerInterface $entityManager,
        private readonly EventDispatcherInterface $dispatcher)
    {
    }

    public function __invoke(DeleteUserCommand $command)
    {
        $user = $this->queryHandler->__invoke(new GetUserByIDQuery($command->id));

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        $this->dispatcher->dispatch(new UserDeletedEvent($user), UserDeletedEvent::NAME);
    }
}
