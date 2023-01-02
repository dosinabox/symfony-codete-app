<?php

namespace App\UserInterface\Http\BlogPosts;

use App\Application\Command\CreateBlogPostCommand;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class CreateBlogPostController extends AbstractController
{
    public function __invoke(Request $request, #[CurrentUser] ?User $user, MessageBusInterface $commandBus): JsonResponse
    {
        $requestContent = json_decode($request->getContent());

        try {
            $envelope = $commandBus->dispatch(new CreateBlogPostCommand(
                $requestContent->title ?? null,
                $requestContent->content ?? null,
                (array)($requestContent->tags ?? []),
                $user));
        } catch (\AssertionError $error) {
            throw new BadRequestHttpException($error->getMessage());
        }

        //TODO replace with UID and don't use envelope
        $handledStamp = $envelope->last(HandledStamp::class);
        $post = $handledStamp->getResult();

        return $this->json([
            'message'   => 'Post ' . $post->getId() . ' created: ' . $post->getTitle(),
            'postID'    => $post->getId(),
        ]);
    }
}
