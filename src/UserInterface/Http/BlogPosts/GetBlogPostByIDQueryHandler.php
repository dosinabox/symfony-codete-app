<?php

namespace App\UserInterface\Http\BlogPosts;

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
        $post = $repository->find($query->id);

        if($post instanceof Post)
        {
            return $post;
        }

        throw new NotFoundHttpException('Blog post ' . $query->id . ' not found!');
    }
}
