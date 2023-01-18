<?php

namespace App\UserInterface\Http\BlogPosts;

use App\Application\Query\GetBlogPostByUUIDQuery;
use App\Application\Query\GetBlogPostByUUIDQueryHandler;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Uid\Uuid;

class GetBlogPostByUUIDController extends AbstractController
{
    public function __construct(private readonly GetBlogPostByUUIDQueryHandler $handler)
    {
    }

    public function __invoke(Uuid $uuid): JsonResponse
    {
        $post = $this->handler->handle(new GetBlogPostByUUIDQuery($uuid));

        return $this->json([
            'id'        => $post->getId(),
            'uuid'      => $post->uuid,
            'title'     => $post->getTitle(),
            'content'   => $post->getContent(),
            'author'    => $post->getAuthor()->getUserName(),
            'tags'      => $post->getTags()->map(fn (Tag $tag): string =>
                $tag->getName())->toArray(),
        ]);
    }
}
