<?php

namespace App\Controller;

use App\Application\Query\GetBlogPostByIDQuery;
use App\Application\Query\GetBlogPostByIDQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetBlogPostController extends AbstractController
{
    public function __construct(private readonly GetBlogPostByIDQueryHandler $handler)
    {
    }

    public function __invoke(int $id): JsonResponse
    {
        $post = $this->handler->handle(new GetBlogPostByIDQuery($id));
        $tags = [];

        foreach ($post->getTags() as $tag) {
            $tags[] = $tag->getName();
        }

        return $this->json([
            'id'        => $post->getId(),
            'title'     => $post->getTitle(),
            'content'   => $post->getContent(),
            'tags'      => $tags
        ]);
    }
}
