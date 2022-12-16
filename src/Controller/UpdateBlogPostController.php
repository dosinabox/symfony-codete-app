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
        $requestContent = json_decode($request->getContent());
        $post = $this->handler->handle(new UpdateBlogPostCommand(
                $requestContent->title,
                $requestContent->content,
                (array)($requestContent->tags ?? []),
                $id)
        );

        return $this->json([
            'message' => 'Post ' . $post->getId() . ' updated: ' . $post->getTitle()
        ]);
    }
}
