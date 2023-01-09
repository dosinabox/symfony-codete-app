<?php

namespace App\Application\Command;

use Symfony\Component\Uid\Uuid;

class DeleteBlogPostCommand
{
    public function __construct(public Uuid $uuid)
    {
    }
}
