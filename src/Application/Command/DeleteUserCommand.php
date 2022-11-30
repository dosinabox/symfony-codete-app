<?php

namespace App\Application\Command;

class DeleteUserCommand
{
    public function __construct(public int $id)
    {
    }
}
