<?php

namespace App\Application\Command;

class CreateUserCommand
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $password
    ) {
        assert(!is_numeric($this->firstName));
        assert(!is_numeric($this->lastName));
        assert(filter_var($this->email, FILTER_VALIDATE_EMAIL));
    }
}
