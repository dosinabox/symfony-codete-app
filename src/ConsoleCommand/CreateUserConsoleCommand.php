<?php

namespace App\ConsoleCommand;

use App\Application\Command\CreateUserCommandHandler;
use App\Application\Command\CreateUserCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(name: 'codete-app:create-user',description: 'Create a new user')]
class CreateUserConsoleCommand extends Command
{
    public function __construct(readonly private CreateUserCommandHandler $handler)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('firstName', InputArgument::REQUIRED, 'First name of the user.');
        $this->addArgument('lastName', InputArgument::REQUIRED, 'Last name of the user.');
        $this->addArgument('email', InputArgument::REQUIRED, 'Email of the user.');
        $this->addArgument('password', InputArgument::REQUIRED, 'Password.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->handler->__invoke(new CreateUserCommand(
            $input->getArgument('firstName'),
            $input->getArgument('lastName'),
            $input->getArgument('email'),
            $input->getArgument('password')
            ));
        $output->writeln('User ' . $user->getId() . ' created: ' . $user->getFirstName() . ' ' . $user->getLastName());

        return Command::SUCCESS;
    }
}
