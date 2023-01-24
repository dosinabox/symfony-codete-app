<?php

namespace App\Application\Query;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ListUsersQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /**
     * @return User[]
     */
    public function __invoke(ListUsersQuery $query): array
    {
        $repository = $this->em->getRepository(User::class);

        return $repository->findAll();
    }
}
