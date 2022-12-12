<?php

namespace App\Controller;

use App\Application\Command\CreateBlogPostCommand;
use App\Application\Command\CreateBlogPostCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CreateBlogPostController extends AbstractController
{
    public function __construct(private readonly CreateBlogPostCommandHandler $handler)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        //TODO tags type is mixed
        $post = $this->handler->handle(new CreateBlogPostCommand(
            $request->request->get('title'),
            $request->request->get('content'),
            $request->request->get('tags'))
        );

        return $this->json([
            'message' => 'Post ' . $post->getId() . ' created: ' . $post->getTitle()
        ]);
    }
}
