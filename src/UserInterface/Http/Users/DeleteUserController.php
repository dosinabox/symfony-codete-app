<?php

namespace App\UserInterface\Http\Users;

use App\Application\Command\DeleteUserCommand;
use App\Application\Command\DeleteUserCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteUserController extends AbstractController
{
    public function __construct(private readonly DeleteUserCommandHandler $deleteHandler)
    {
    }

    public function __invoke(int $id): JsonResponse
    {
        $this->deleteHandler->__invoke(new DeleteUserCommand($id));

        return $this->json([
            'message' => 'User ' . $id . ' deleted!',
        ]);
    }
}
