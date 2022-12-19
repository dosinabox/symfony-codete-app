<?php

namespace App\Application\Command;

class DeleteBlogPostCommand
{
    public function __construct(public int $id)
    {
    }
}
