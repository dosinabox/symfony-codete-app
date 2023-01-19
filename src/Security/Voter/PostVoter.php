<?php

namespace App\Security\Voter;

use App\Entity\Post;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PostVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    //public const VIEW = 'POST_VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $subject instanceof Post && $attribute === self::EDIT;
    }

    /**
     * @param string $attribute
     * @param Post $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        return $token->getUser()->getId() === $subject->getAuthor()->getId() || in_array('ROLE_ADMIN', $token->getRoleNames());
    }
}
