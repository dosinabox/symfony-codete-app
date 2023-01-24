<?php

namespace App\Application\Command;

use App\Entity\User;
use App\Application\Query\GetUserByIDQuery;
use App\Event\UserUpdatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class UpdateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MessageBusInterface $queryBus,
        private readonly EntityManagerInterface $entityManager,
        private readonly EventDispatcherInterface $dispatcher)
    {
    }

    public function __invoke(UpdateUserCommand $command): User
    {
        $user = $this->queryBus->dispatch(new GetUserByIDQuery($command->id))
            ->last(HandledStamp::class)
            ->getResult();

        $user->setFirstName($command->firstName);
        $user->setLastName($command->lastName);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->dispatcher->dispatch(new UserUpdatedEvent($user), UserUpdatedEvent::NAME);

        return $user;
    }
}
