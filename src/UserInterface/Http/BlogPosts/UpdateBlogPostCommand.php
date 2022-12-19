<?php

namespace App\UserInterface\Http\BlogPosts;

class UpdateBlogPostCommand
{
    public function __construct(public string $title, public string $content, public array $tags, public int $id)
    {
    }
}
