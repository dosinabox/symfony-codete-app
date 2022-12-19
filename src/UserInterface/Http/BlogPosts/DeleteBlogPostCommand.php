<?php

namespace App\UserInterface\Http\BlogPosts;

class DeleteBlogPostCommand
{
    public function __construct(public int $id)
    {
    }
}
