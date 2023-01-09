<?php

namespace App\UserInterface\Http\BlogPosts;

use App\Application\Command\DeleteBlogPostCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

class DeleteBlogPostController extends AbstractController
{
    public function __invoke(string $id, MessageBusInterface $commandBus): JsonResponse
    {
        //TODO use Value Resolvers
        $uuid = Uuid::fromString($id);
        $commandBus->dispatch(new DeleteBlogPostCommand($uuid));

        return $this->json([
            'message' => 'Post ' . $uuid . ' deleted!',
        ]);
    }
}
