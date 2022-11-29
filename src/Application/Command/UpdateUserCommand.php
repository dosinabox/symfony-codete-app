<?php

namespace App\Application\Command;

use App\Entity\User;

class UpdateUserCommand
{
    public function __construct(public string $firstName, public string $lastName, public User $user)
    {
        assert(!is_numeric($this->firstName));
        assert(!is_numeric($this->lastName));
    }
}
