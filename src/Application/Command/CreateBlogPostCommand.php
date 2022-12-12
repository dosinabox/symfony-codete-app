<?php

namespace App\Application\Command;

class CreateBlogPostCommand
{
    public function __construct(public string $title, public string $content, public array $tags)
    {
    }
}
