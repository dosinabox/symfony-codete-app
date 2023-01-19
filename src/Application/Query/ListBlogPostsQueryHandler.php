<?php

namespace App\Application\Query;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class ListBlogPostsQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @return Post[]
     */
    public function __invoke(ListBlogPostsQuery $query): array
    {
        $repository = $this->entityManager->getRepository(Post::class);

        return $repository->findAll();
    }
}
