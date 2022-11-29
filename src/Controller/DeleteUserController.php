<?php

namespace App\Controller;

use App\Application\Command\DeleteUserCommand;
use App\Application\Command\DeleteUserCommandHandler;
use App\Application\Query\GetUserByIDQuery;
use App\Application\Query\GetUserByIDQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteUserController extends AbstractController
{
    public function __construct(
        readonly private GetUserByIDQueryHandler $getHandler,
        readonly private DeleteUserCommandHandler $deleteHandler)
    {
    }

    public function __invoke(int $id): JsonResponse
    {
        $user = $this->getHandler->handle(new GetUserByIDQuery($id));
        $this->deleteHandler->handle(new DeleteUserCommand($user));

        return $this->json([
            'message' => 'User ' . $id . ' deleted!',
        ]);
    }
}
