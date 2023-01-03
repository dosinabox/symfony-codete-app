<?php

namespace App\UserInterface\Http\BlogPosts;

use App\Application\Command\CreateBlogPostCommand;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Uid\Uuid;

class CreateBlogPostController extends AbstractController
{
    public function __invoke(Request $request, #[CurrentUser] ?User $user, MessageBusInterface $commandBus): JsonResponse
    {
        $requestContent = json_decode($request->getContent());
        $uuid = Uuid::v4();

        try {
            $commandBus->dispatch(new CreateBlogPostCommand(
                $requestContent->title ?? null,
                $requestContent->content ?? null,
                (array)($requestContent->tags ?? []),
                $user,
                $uuid));
        } catch (\AssertionError $error) {
            throw new BadRequestHttpException($error->getMessage());
        }

        return $this->json([
            'message'   => 'Post ' . $uuid . ' created: ' . $requestContent->title,
            'postID'    => $uuid,
        ]);
    }
}
