<?php

namespace App\UserInterface\Http\BlogPosts;

use App\Application\Command\UpdateBlogPostCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

class UpdateBlogPostController extends AbstractController
{
    public function __invoke(string $id, Request $request, MessageBusInterface $commandBus): JsonResponse
    {
        $requestContent = json_decode($request->getContent());

        //TODO use Value Resolvers
        $uuid = Uuid::fromString($id);

        try {
            $commandBus->dispatch(new UpdateBlogPostCommand(
                $requestContent->title,
                $requestContent->content,
                (array)($requestContent->tags ?? []),
                $uuid)
            );
        } catch (\AssertionError $error) {
            throw new BadRequestHttpException($error->getMessage());
        }

        return $this->json([
            'message' => 'Post ' . $uuid . ' updated: ' . $requestContent->title
        ]);
    }
}
