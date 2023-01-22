<?php

namespace App\UserInterface\Http\BlogPosts;

use App\Application\Query\GetBlogPostByIDQuery;
use App\Application\Query\GetBlogPostByIDQueryHandler;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Uid\Uuid;

class GetBlogPostController extends AbstractController
{
    public function __construct(private readonly GetBlogPostByIDQueryHandler $handler)
    {
    }

    public function __invoke(int|Uuid $id): JsonResponse
    {
        $post = $this->handler->__invoke(new GetBlogPostByIDQuery($id));

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
