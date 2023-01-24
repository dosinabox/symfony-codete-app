<?php

namespace App\Application\Query;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Uid\Uuid;

class GetBlogPostByIDQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(GetBlogPostByIDQuery $query)
    {
        $repository = $this->entityManager->getRepository(Post::class);

        if($query->id instanceof Uuid) {
            $post = $repository->findOneByUuid($query->id);
        } else {
            $post = $repository->find($query->id);
        }

        if($post instanceof Post)
        {
            return $post;
        }

        throw new NotFoundHttpException('Blog post ' . $query->id . ' not found!');
    }
}
