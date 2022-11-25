<?php

namespace App\Controller;

use App\Application\Query\GetUserByIDQuery;
use App\Application\Query\GetUserByIDQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetUserController extends AbstractController
{
    public function __construct(readonly private GetUserByIDQueryHandler $handler)
    {

    }

    public function __invoke(int $id): JsonResponse
    {
        $user = $this->handler->handle(new GetUserByIDQuery($id));

        return $this->json([
            'message' => 'Welcome to your new controller! Name is ' . $user->getFirstName() . ', last name is ' . $user->getLastName(),
            'path' => 'src/Controller/GetNameController.php',
        ]);
    }
}
