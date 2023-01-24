<?php

namespace App\Application\Command;

use App\Application\Query\GetBlogPostByIDQuery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class DeleteBlogPostCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MessageBusInterface $queryBus,
        private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(DeleteBlogPostCommand $command): void
    {
        $post = $this->queryBus->dispatch(new GetBlogPostByIDQuery($command->uuid))
            ->last(HandledStamp::class)
            ->getResult();

        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }
}
