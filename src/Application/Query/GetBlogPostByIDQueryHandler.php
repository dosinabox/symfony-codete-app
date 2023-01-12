<?php

namespace App\Application\Query;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetBlogPostByIDQueryHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function handle(GetBlogPostByIDQuery $query): Post
    {
        $repository = $this->entityManager->getRepository(Post::class);

        if(is_int($query->uuid))
        {
            $post = $repository->find($query->uuid);
        } else {
            $post = $repository->findOneByUuid($query->uuid);
        }

        if($post instanceof Post)
        {
            return $post;
        }

        throw new NotFoundHttpException('Blog post ' . $query->uuid . ' not found!');
    }
}
