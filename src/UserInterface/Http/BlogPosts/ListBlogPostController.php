<?php

namespace App\UserInterface\Http\BlogPosts;

use App\Application\Query\ListBlogPostsQuery;
use App\Application\Query\ListBlogPostsQueryHandler;
use App\Entity\Post;
use App\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListBlogPostController extends AbstractController
{
    public function __construct(private readonly ListBlogPostsQueryHandler $handler)
    {
    }

    public function __invoke(): JsonResponse
    {
        $posts = $this->handler->__invoke(new ListBlogPostsQuery());
        $collection = new ArrayCollection($posts);
        $postsCollection = $collection->map(fn (Post $post): array => [
            'id'        => $post->getId(),
            'title'     => $post->getTitle(),
            'author'    => $post->getAuthor()->getUserName(),
            'tags'      => $post->getTags()->map(fn (Tag $tag): string =>
                $tag->getName())->toArray(),
        ]);

        return $this->json($postsCollection->toArray());
    }
}
