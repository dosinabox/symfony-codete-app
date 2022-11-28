<?php

namespace App\Application\Query;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ListUsersQueryHandler
{
    public function __construct(private readonly EntityManagerInterface $em)
    {

    }

    /**
     * @return User[]
     */
    public function handle(ListUsersQuery $query): array
    {
        $repository = $this->em->getRepository(User::class);

        return $repository->findAll();
    }
}
