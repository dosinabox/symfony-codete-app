<?php

namespace App\UserInterface\Http\Mapper\BlogPost;

use App\Entity\Post;
use App\Entity\Tag;

class BlogPostResponseMapper
{
    public function map(Post $post): array
    {
        return [
            'id'        => $post->getId(),
            'uuid'      => $post->uuid,
            'title'     => $post->getTitle(),
            'content'   => $post->getContent(),
            'author'    => $post->getAuthor()->getUserName(),
            'tags'      => $post->getTags()->map(fn (Tag $tag): string =>
            $tag->getName())->toArray(),
        ];
    }
}
