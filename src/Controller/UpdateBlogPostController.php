<?php

namespace App\Controller;

use App\Application\Command\UpdateBlogPostCommand;
use App\Application\Command\UpdateBlogPostCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateBlogPostController extends AbstractController
{
    public function __construct(private readonly UpdateBlogPostCommandHandler $handler)
    {
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {
        //TODO tags type is mixed
        $post = $this->handler->handle(new UpdateBlogPostCommand(
            $request->request->get('title'),
            $request->request->get('content'),
            $request->request->get('tags'),
            $id)
        );

        return $this->json([
            'message' => 'Post ' . $post->getId() . ' updated: ' . $post->getTitle()
        ]);
    }
}
