<?php

namespace App\UserInterface\Http\Users;

use App\Application\Command\CreateUserCommand;
use App\Application\Command\CreateUserCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateUserController extends AbstractController
{
    public function __construct(private readonly CreateUserCommandHandler $handler)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $user = $this->handler->__invoke(new CreateUserCommand(
                    $request->request->get('firstName'),
                    $request->request->get('lastName'),
                    $request->request->get('email'),
                    $request->request->get('password'))
            );
        } catch (\AssertionError $error) {
            throw new BadRequestHttpException($error->getMessage());
        }

        return $this->json([
            'message' => 'User ' . $user->getId() . ' created: ' . $user->getFirstName() . ' ' . $user->getLastName(),
        ]);
    }
}
