<?php

namespace App\Application\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(name: 'codete-app:create-user',description: 'Create a new user')]
class CreateUserCommand extends Command
{
    public function __construct(readonly private CreateUserCommandHandler $handler)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('firstName', InputArgument::REQUIRED, 'First name of the user.');
        $this->addArgument('lastName', InputArgument::REQUIRED, 'Last name of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->handler->handle($input->getArgument('firstName'), $input->getArgument('lastName'));
        $output->writeln('User ' . $user->getId() . ' created: ' . $user->getFirstName() . ' ' . $user->getLastName());

        return Command::SUCCESS;
    }
}
