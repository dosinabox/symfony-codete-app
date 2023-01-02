<?php

namespace App\UserInterface\Http\BlogPosts;

use App\Application\Command\DeleteBlogPostCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteBlogPostController extends AbstractController
{
    public function __invoke(int $id, MessageBusInterface $commandBus): JsonResponse
    {
        $commandBus->dispatch(new DeleteBlogPostCommand($id));

        return $this->json([
            'message' => 'Post ' . $id . ' deleted!',
        ]);
    }
}
