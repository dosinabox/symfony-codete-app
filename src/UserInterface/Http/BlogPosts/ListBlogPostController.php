<?php

namespace App\UserInterface\Http\BlogPosts;

use App\Application\Query\ListBlogPostsQuery;
use App\Application\Query\ListBlogPostsQueryHandler;
use App\Entity\Post;
use App\UserInterface\Http\Mapper\BlogPost\BlogPostResponseMapper;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListBlogPostController extends AbstractController
{
    public function __construct(
        private readonly ListBlogPostsQueryHandler $handler,
        private readonly BlogPostResponseMapper $mapper)
    {
    }

    public function __invoke(): JsonResponse
    {
        $posts = $this->handler->__invoke(new ListBlogPostsQuery());
        $collection = new ArrayCollection($posts);
        $postsCollection = $collection->map(fn (Post $post): array => $this->mapper->map($post));

        return $this->json($postsCollection->toArray());
    }
}
