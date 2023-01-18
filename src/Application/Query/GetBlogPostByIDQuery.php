<?php

namespace App\Application\Query;

class GetBlogPostByIDQuery
{
    public function __construct(public readonly int $id)
    {
    }
}
