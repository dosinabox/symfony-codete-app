<?php

namespace App\UserInterface\Http\Mapper\BlogPost;

use App\Entity\Post;
use App\Entity\Tag;
use FOS\RestBundle\Serializer\Serializer;

class BlogPostResponseMapper
{
    public function __construct(private readonly Serializer $serializer)
    {
    }

    public function map(Post $post)
    {
        return $this->json([
            'id'        => $post->getId(),
            'title'     => $post->getTitle(),
            'content'   => $post->getContent(),
            'author'    => $post->getAuthor()->getUserName(),
            'tags'      => $post->getTags()->map(fn (Tag $tag): string =>
            $tag->getName())->toArray(),
        ]);
    }
}