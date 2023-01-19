<?php

namespace App\Application\Query;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetBlogPostByIDQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(GetBlogPostByIDQuery $query)
    {
        $repository = $this->entityManager->getRepository(Post::class);
        $post = $repository->findOneByUuid($query->uuid);

        if($post instanceof Post)
        {
            return $post;
        }

        throw new NotFoundHttpException('Blog post ' . $query->uuid . ' not found!');
    }
}
