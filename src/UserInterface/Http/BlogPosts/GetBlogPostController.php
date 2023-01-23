<?php

namespace App\UserInterface\Http\BlogPosts;

use App\Application\Query\GetBlogPostByIDQuery;
use App\Application\Query\GetBlogPostByIDQueryHandler;
use App\UserInterface\Http\Mapper\BlogPost\BlogPostResponseMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class GetBlogPostController extends AbstractController
{
    public function __construct(
        private readonly GetBlogPostByIDQueryHandler $handler,
        private readonly BlogPostResponseMapper $mapper)
    {
    }

    public function __invoke(int|Uuid $id): Response
    {
        $post = $this->handler->handle(new GetBlogPostByIDQuery($id));

        return $this->mapper->serialize($post);
    }
}
