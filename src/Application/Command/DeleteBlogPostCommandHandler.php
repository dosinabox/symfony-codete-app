<?php

namespace App\Application\Command;

use App\Application\Query\GetBlogPostByIDQuery;
use App\Application\Query\GetBlogPostByIDQueryHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteBlogPostCommandHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly GetBlogPostByIDQueryHandler $queryHandler,
        private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(DeleteBlogPostCommand $command): void
    {
        $post = $this->queryHandler->handle(new GetBlogPostByIDQuery($command->id));

        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }
}
