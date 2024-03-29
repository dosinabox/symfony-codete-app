<?php

namespace App\Application\Command;

class UpdateUserCommand
{
    public function __construct(public string $firstName, public string $lastName, public int $id)
    {
        assert(!is_numeric($this->firstName));
        assert(!is_numeric($this->lastName));
    }
}
