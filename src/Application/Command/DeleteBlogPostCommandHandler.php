<?php

namespace App\Application\Command;

use App\Application\Query\GetBlogPostByIDQuery;
use App\Application\Query\GetBlogPostByIDQueryHandler;
use Doctrine\ORM\EntityManagerInterface;

class DeleteBlogPostCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly GetBlogPostByIDQueryHandler $queryHandler,
        private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(DeleteBlogPostCommand $command): void
    {
        $post = $this->queryHandler->__invoke(new GetBlogPostByIDQuery($command->uuid));

        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }
}
