<?php

namespace App\UserInterface\Http\BlogPosts;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteBlogPostController extends AbstractController
{
    public function __construct(private readonly DeleteBlogPostCommandHandler $deleteHandler)
    {
    }

    public function __invoke(int $id): JsonResponse
    {
        $this->deleteHandler->handle(new DeleteBlogPostCommand($id));

        return $this->json([
            'message' => 'Post ' . $id . ' deleted!',
        ]);
    }
}
