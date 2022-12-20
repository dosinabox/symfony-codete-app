<?php

namespace App\UserInterface\Http\BlogPosts;

use App\Application\Command\CreateBlogPostCommand;
use App\Application\Command\CreateBlogPostCommandHandler;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class CreateBlogPostController extends AbstractController
{
    public function __construct(private readonly CreateBlogPostCommandHandler $handler)
    {
    }

    public function __invoke(Request $request, #[CurrentUser] ?User $user): JsonResponse
    {
        $requestContent = json_decode($request->getContent());

        try {
            $post = $this->handler->handle(new CreateBlogPostCommand(
                    $requestContent->title ?? null,
                    $requestContent->content ?? null,
                    (array)($requestContent->tags ?? []),
                    $user)
            );
        } catch (\AssertionError $error) {
            throw new BadRequestHttpException($error->getMessage());
        }

        return $this->json([
            'message'   => 'Post ' . $post->getId() . ' created: ' . $post->getTitle(),
            'postID'    => $post->getId(),
        ]);
    }
}
