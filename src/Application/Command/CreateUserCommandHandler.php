<?php

namespace App\Application\Command;

use App\Entity\User;
use App\Event\UserCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly EventDispatcherInterface $dispatcher,
        private readonly UserPasswordHasherInterface $hasher
    ) {
    }

    public function __invoke(CreateUserCommand $command): User
    {
        $user = new User();
        $user->setFirstName($command->firstName);
        $user->setLastName($command->lastName);
        $user->setEmail($command->email);
        $user->setPassword($this->hasher->hashPassword($user, $command->password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->dispatcher->dispatch(new UserCreatedEvent($user), UserCreatedEvent::NAME);

        return $user;
    }
}
