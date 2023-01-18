<?php

namespace App\Application\Query;

use Symfony\Component\Uid\Uuid;

class GetBlogPostByUUIDQuery
{
    public function __construct(public readonly Uuid $uuid)
    {
    }
}
