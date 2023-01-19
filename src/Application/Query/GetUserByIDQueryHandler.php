<?php

namespace App\Application\Query;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetUserByIDQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function __invoke(GetUserByIDQuery $query)
    {
        $repository = $this->em->getRepository(User::class);
        $user = $repository->find($query->id);

        if($user instanceof User)
        {
            return $user;
        }

        throw new NotFoundHttpException('User ' . $query->id . ' not found!');
    }
}
