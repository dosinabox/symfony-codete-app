<?php

namespace App\Application\Command;

use App\Application\Query\GetBlogPostByIDQuery;
use App\Application\Query\GetBlogPostByIDQueryHandler;
use Doctrine\ORM\EntityManagerInterface;

class DeleteBlogPostCommandHandler
{
    public function __construct(
        private readonly GetBlogPostByIDQueryHandler $queryHandler,
        private readonly EntityManagerInterface $entityManager)
    {
    }

    public function handle(DeleteBlogPostCommand $command): void
    {
        $post = $this->queryHandler->handle(new GetBlogPostByIDQuery($command->id));

        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }
}
