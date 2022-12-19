<?php

namespace App\UserInterface\Http\BlogPosts;

use App\Application\Query\GetBlogPostByIDQuery;
use App\Application\Query\GetBlogPostByIDQueryHandler;
use App\Entity\Tag;
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

        return $this->json([
            'id'        => $post->getId(),
            'title'     => $post->getTitle(),
            'content'   => $post->getContent(),
            'author'    => $post->getAuthor()->getUserName(),
            'tags'      => $post->getTags()->map(fn (Tag $tag): string =>
                $tag->getName())->toArray(),
        ]);
    }
}
