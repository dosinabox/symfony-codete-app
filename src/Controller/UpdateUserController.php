<?php

namespace App\Controller;

use App\Application\Command\UpdateUserCommand;
use App\Application\Command\UpdateUserCommandHandler;
use App\Application\Query\GetUserByIDQuery;
use App\Application\Query\GetUserByIDQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UpdateUserController extends AbstractController
{
    public function __construct(
        readonly private GetUserByIDQueryHandler $getHandler,
        readonly private UpdateUserCommandHandler $updateHandler)
    {
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {
        $user = $this->getHandler->handle(new GetUserByIDQuery($id));
        $oldFirstName = $user->getFirstName();
        $oldLastName = $user->getLastName();

        try {
            $user = $this->updateHandler->handle(
                new UpdateUserCommand(
                    $request->request->get('firstName'),
                    $request->request->get('lastName'),
                    $user));
        } catch (\AssertionError $error) {
            throw new BadRequestHttpException($error->getMessage());
        }

        return $this->json([
            'message' => 'User ' . $user->getId() . ' updated: ' .
                $oldFirstName . ' ' . $oldLastName  . ' -> ' .
                $user->getFirstName() . ' ' . $user->getLastName(),
        ]);
    }
}
