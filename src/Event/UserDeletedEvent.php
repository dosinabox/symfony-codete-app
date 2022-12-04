<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserDeletedEvent extends Event
{
    public const NAME = 'user.deleted';

    public function __construct(public User $user)
    {
    }
}
