<?php

namespace App\UserInterface\Http\Users;

use App\Application\Command\UpdateUserCommand;
use App\Application\Command\UpdateUserCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UpdateUserController extends AbstractController
{
    public function __construct(private readonly UpdateUserCommandHandler $updateHandler)
    {
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {
        try {
            $user = $this->updateHandler->__invoke(
                new UpdateUserCommand(
                    $request->request->get('firstName'),
                    $request->request->get('lastName'),
                    $id));
        } catch (\AssertionError $error) {
            throw new BadRequestHttpException($error->getMessage());
        }

        return $this->json([
            'message' => 'User ' . $user->getId() . ' updated: ' . $user->getFirstName() . ' ' . $user->getLastName(),
        ]);
    }
}
