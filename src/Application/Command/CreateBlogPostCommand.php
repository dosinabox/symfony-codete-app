<?php

namespace App\Application\Command;

use App\Entity\User;

class CreateBlogPostCommand
{
    public function __construct(public string $title, public string $content, public array $tags, public User $author)
    {
    }
}