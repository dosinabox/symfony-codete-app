<?php

namespace App\UserInterface\Http\BlogPosts;

use App\Application\Command\UpdateBlogPostCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class UpdateBlogPostController extends AbstractController
{
    public function __invoke(int $id, Request $request, MessageBusInterface $commandBus): JsonResponse
    {
        $requestContent = json_decode($request->getContent());

        try {
            $envelope = $commandBus->dispatch(new UpdateBlogPostCommand(
                    $requestContent->title,
                    $requestContent->content,
                    (array)($requestContent->tags ?? []),
                    $id)
            );
        } catch (\AssertionError $error) {
            throw new BadRequestHttpException($error->getMessage());
        }

        //TODO replace with UID and don't use envelope
        $handledStamp = $envelope->last(HandledStamp::class);
        $post = $handledStamp->getResult();

        return $this->json([
            'message' => 'Post ' . $post->getId() . ' updated: ' . $post->getTitle()
        ]);
    }
}
