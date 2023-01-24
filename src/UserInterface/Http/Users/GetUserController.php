<?php

namespace App\UserInterface\Http\Users;

use App\Application\Query\GetUserByIDQuery;
use App\Application\Query\GetUserByIDQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetUserController extends AbstractController
{
    public function __construct(private readonly GetUserByIDQueryHandler $handler)
    {
    }

    public function __invoke(int $id): JsonResponse
    {
        $user = $this->handler->__invoke(new GetUserByIDQuery($id));

        return $this->json([
            'message' => 'User ' . $user->getId() . ': ' . $user->getFirstName() . ' ' . $user->getLastName(),
        ]);
    }
}
