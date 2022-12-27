<?php

use PHPUnit\Framework\TestCase;
use App\Entity\User;
use App\Application\Command\CreateUserCommandHandler;
use App\Application\Command\CreateUserCommand;

class StackTest extends TestCase
{
    public function testCreate()
    {
        /*$command = $this->getMockBuilder(CreateUserCommand::class)
            ->disableOriginalConstructor()
            ->getMock();
        $command->firstName = 'fff';
        $command->lastName = 'lll';
        $command->email = 'e@e.by';
        $command->password = 'p';
        $handler = $this->createMock(CreateUserCommandHandler::class);
        $user = $handler->handle($command);*/

        $user = new User();
        $user->setFirstName('firstName');
        $user->setLastName('lastName');
        $user->setEmail('email@test.com');
        $user->setPassword('password');

        $this->assertEquals('firstName', $user->getFirstName());
        $this->assertEquals('lastName', $user->getLastName());
        $this->assertEquals('email@test.com', $user->getUserIdentifier());
        $this->assertEquals('password', $user->getPassword());
        $this->assertContains('ROLE_USER', $user->getRoles());
    }
}
