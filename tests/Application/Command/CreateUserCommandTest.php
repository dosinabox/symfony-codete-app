<?php

namespace App\Tests\Application\Command;

use App\Application\Command\CreateUserCommand;
use App\Application\Command\CreateUserCommandHandler;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;

class CreateUserCommandTest extends TestCase
{
    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->dispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->hasher = $this->createMock(UserPasswordHasher::class);
        $this->commandHandler = new CreateUserCommandHandler($this->entityManager, $this->dispatcher, $this->hasher);
    }

    public function testAssertionError()
    {
        $this->expectException(\AssertionError::class);
        $this->commandHandler->__invoke(new CreateUserCommand(
            '1', '2', 'email@test.com', 'password'
        ));
    }
}
