<?php

namespace App\Controller;

use App\Application\Query\ListUsersQuery;
use App\Entity\User;
use App\Application\Query\ListUsersQueryHandler;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListUsersController extends AbstractController
{
    public function __construct(private readonly ListUsersQueryHandler $handler)
    {
    }

    public function __invoke(): JsonResponse
    {
        $users = $this->handler->handle(new ListUsersQuery());
        $collection = new ArrayCollection($users);
        $usersCollection = $collection->map(fn (User $user): array => [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getUserName(),
            'roles' => $user->getRoles(),
        ]);

        return $this->json($usersCollection->toArray());
    }
}
