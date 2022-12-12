<?php

namespace App\Controller;

use App\Application\Query\ListBlogPostsQueryHandler;
use App\Entity\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Tag;

class ListBlogPostController extends AbstractController
{
    public function __construct(private readonly ListBlogPostsQueryHandler $handler)
    {
    }

    public function __invoke(): JsonResponse
    {
        $posts = $this->handler->handle();
        $collection = new ArrayCollection($posts);
        $postsCollection = $collection->map(fn (Post $post): array => [
            'id'        => $post->getId(),
            'title'     => $post->getTitle(),
            'content'   => $post->getContent(),
            'tags'      => $post->getTags()->map(fn (Tag $tag): string =>
                $tag->getName())->toArray(),
        ]);

        return $this->json($postsCollection->toArray());
    }
}
