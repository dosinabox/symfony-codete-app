<?php

namespace App\Controller;

use App\Application\Command\CreateUserCommand;
use App\Application\Command\CreateUserCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateUserController extends AbstractController
{
    public function __construct(readonly private CreateUserCommandHandler $handler)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $user = $this->handler->handle(new CreateUserCommand(
                    $request->request->get('firstName'),
                    $request->request->get('lastName'))
            );
        } catch (\AssertionError $error) {
            throw new BadRequestHttpException($error->getMessage());
        }

        return $this->json([
            'message' => 'User ' . $user->getId() . ' created: ' . $user->getFirstName() . ' ' . $user->getLastName(),
        ]);
    }
}
