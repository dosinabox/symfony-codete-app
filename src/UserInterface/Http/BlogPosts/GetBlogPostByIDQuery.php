<?php

namespace App\UserInterface\Http\BlogPosts;

class GetBlogPostByIDQuery
{
    public function __construct(public int $id)
    {

    }
}
