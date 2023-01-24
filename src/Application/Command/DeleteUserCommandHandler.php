<?php

namespace App\Application\Command;

use App\Application\Query\GetUserByIDQuery;
use App\Event\UserDeletedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MessageBusInterface $queryBus,
        private readonly EntityManagerInterface $entityManager,
        private readonly EventDispatcherInterface $dispatcher)
    {
    }

    public function __invoke(DeleteUserCommand $command)
    {
        $user = $this->queryBus->dispatch(new GetUserByIDQuery($command->id))
            ->last(HandledStamp::class)
            ->getResult();

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        $this->dispatcher->dispatch(new UserDeletedEvent($user), UserDeletedEvent::NAME);
    }
}
