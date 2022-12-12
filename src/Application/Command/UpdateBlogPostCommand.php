<?php

namespace App\Application\Command;

class UpdateBlogPostCommand
{
    public function __construct(public string $title, public string $content, public array $tags, public int $id)
    {
    }
}
