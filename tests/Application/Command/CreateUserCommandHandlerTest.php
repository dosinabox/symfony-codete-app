<?php

namespace App\Tests\Application\Command;

use App\Application\Command\CreateUserCommand;
use App\Application\Command\CreateUserCommandHandler;
use App\Entity\User;
use App\Event\UserCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use PHPUnit\Framework\MockObject\MockObject;

class CreateUserCommandHandlerTest extends TestCase
{
    private CreateUserCommandHandler $commandHandler;

    private MockObject|UserPasswordHasherInterface $hasher;

    private MockObject|EntityManagerInterface $entityManager;

    private MockObject|EventDispatcherInterface $dispatcher;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->dispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->hasher = $this->createMock(UserPasswordHasher::class);
        $this->commandHandler = new CreateUserCommandHandler($this->entityManager, $this->dispatcher, $this->hasher);
    }

    public function testHandle()
    {
        //assign
        $user = new User();
        $user->setFirstName('firstName');
        $user->setLastName('lastName');
        $user->setEmail('email@test.com');
        $user->setPassword('hashedPassword');

        //act
        $this->hasher->expects($this->once())->method('hashPassword')->willReturn('hashedPassword');
        $this->entityManager->expects($this->once())->method('persist')->with($user);
        $this->entityManager->expects($this->once())->method('flush');
        $this->dispatcher->expects($this->once())->method('dispatch')->with(new UserCreatedEvent($user));

        $handledUser = $this->commandHandler->__invoke(new CreateUserCommand(
            'firstName', 'lastName', 'email@test.com', 'password'
        ));

        //assert
        $this->assertEquals($user, $handledUser);
        $this->assertEquals('firstName', $handledUser->getFirstName());
        $this->assertEquals('lastName', $handledUser->getLastName());
        $this->assertEquals('email@test.com', $handledUser->getUserName());
        $this->assertEquals('email@test.com', $handledUser->getUserIdentifier());
        $this->assertEquals('hashedPassword', $handledUser->getPassword());
        $this->assertContains('ROLE_USER', $handledUser->getRoles());
    }
}
