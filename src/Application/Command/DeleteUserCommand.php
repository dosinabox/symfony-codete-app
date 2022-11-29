<?php

namespace App\Application\Command;

use App\Entity\User;

class DeleteUserCommand
{
    public function __construct(public User $user)
    {
    }
}
