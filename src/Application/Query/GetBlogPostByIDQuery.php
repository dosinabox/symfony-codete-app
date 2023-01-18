<?php

namespace App\Application\Query;

use Symfony\Component\Uid\Uuid;

class GetBlogPostByIDQuery
{
    public function __construct(public readonly int|Uuid $id)
    {
    }
}
