<?php

namespace App\Application\Query;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class ListBlogPostsQueryHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @return Post[]
     */
    public function handle(): array
    {
        $repository = $this->entityManager->getRepository(Post::class);

        return $repository->findAll();
    }
}
